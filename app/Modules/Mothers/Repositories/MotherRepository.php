<?php

declare(strict_types=1);

class MotherRepository extends Repository
{
    public function search(string $search = '', int $limit = 100): array
    {
        return parent::findAll(
            $this->selectSql() . '
             WHERE pr.role_name = "Mother"
               AND (:search = "" OR CONCAT_WS(" ", p.first_name, p.middle_name, p.last_name) LIKE :term_name
                    OR p.nic LIKE :term_nic OR f.registration_number LIKE :term_family)
             GROUP BY p.person_id
             ORDER BY p.first_name, p.last_name LIMIT :limit',
            ['search' => $search, 'term_name' => '%' . $search . '%', 'term_nic' => '%' . $search . '%', 'term_family' => '%' . $search . '%', 'limit' => $limit]
        );
    }

    public function findById(int $id): ?array
    {
        return $this->findOne($this->selectSql() . ' WHERE p.person_id = :id AND pr.role_name = "Mother" GROUP BY p.person_id LIMIT 1', ['id' => $id]);
    }

    public function eligibleWomen(): array
    {
        return parent::findAll(
            'SELECT p.person_id, CONCAT_WS(" ", p.first_name, p.middle_name, p.last_name) AS full_name,
                    p.nic, p.date_of_birth, f.registration_number AS family_code, pr.role_name
             FROM person p INNER JOIN family f ON f.family_id = p.family_id
             INNER JOIN person_role pr ON pr.person_role_id = p.person_role_id
             WHERE p.gender = "Female" AND p.status = "Active" AND pr.role_name <> "Mother"
             ORDER BY full_name'
        );
    }

    public function markAsMother(int $personId): bool
    {
        $roleId = (int) $this->findScalar('SELECT person_role_id FROM person_role WHERE role_name = "Mother" LIMIT 1');
        if ($roleId < 1) return false;
        $this->execute('UPDATE person SET person_role_id = :role_id WHERE person_id = :person_id AND gender = "Female"', ['role_id' => $roleId, 'person_id' => $personId]);
        return true;
    }

    public function update(int $id, array $data): bool
    {
        $this->execute(
            'UPDATE person SET first_name = :first_name, middle_name = :middle_name,
                last_name = :last_name, nic = :nic, date_of_birth = :date_of_birth,
                phone = :phone, email = :email, education_level = :education_level,
                occupation = :occupation, blood_group = :blood_group,
                marital_status = :marital_status, status = :status
             WHERE person_id = :id',
            [
                'id' => $id,
                'first_name' => trim((string) ($data['first_name'] ?? '')),
                'middle_name' => trim((string) ($data['middle_name'] ?? '')) ?: null,
                'last_name' => trim((string) ($data['last_name'] ?? '')),
                'nic' => trim((string) ($data['nic'] ?? '')) ?: null,
                'date_of_birth' => $data['date_of_birth'] ?? '',
                'phone' => trim((string) ($data['phone'] ?? '')) ?: null,
                'email' => trim((string) ($data['email'] ?? '')) ?: null,
                'education_level' => trim((string) ($data['education_level'] ?? '')) ?: null,
                'occupation' => trim((string) ($data['occupation'] ?? '')) ?: null,
                'blood_group' => trim((string) ($data['blood_group'] ?? '')) ?: null,
                'marital_status' => trim((string) ($data['marital_status'] ?? '')) ?: null,
                'status' => $data['status'] ?? 'Active',
            ]
        );
        return true;
    }

    public function statistics(): array
    {
        return $this->findOne(
            'SELECT COUNT(DISTINCT p.person_id) AS total,
                    COUNT(DISTINCT CASE WHEN pg.current_status = "Ongoing" THEN p.person_id END) AS pregnant,
                    COUNT(DISTINCT CASE WHEN pg.current_status = "Ongoing" AND pg.risk_status = "High" THEN p.person_id END) AS high_risk,
                    COUNT(DISTINCT CASE WHEN pg.current_status = "Ongoing" AND pg.expected_delivery_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY) THEN p.person_id END) AS deliveries_due
             FROM person p INNER JOIN person_role pr ON pr.person_role_id = p.person_role_id
             LEFT JOIN pregnancy pg ON pg.mother_id = p.person_id
             WHERE pr.role_name = "Mother"'
        ) ?? [];
    }

    public function pregnancies(int $motherId): array
    {
        return parent::findAll('SELECT * FROM pregnancy WHERE mother_id = :id ORDER BY registered_date DESC, pregnancy_id DESC', ['id' => $motherId]);
    }

    public function clinicVisits(int $motherId): array
    {
        return parent::findAll(
            'SELECT ca.*, cs.session_type, cs.location,
                    CONCAT_WS(" ", s.first_name, s.middle_name, s.last_name) AS staff_name
             FROM clinic_appointment ca INNER JOIN clinic_session cs ON cs.clinic_session_id = ca.clinic_session_id
             INNER JOIN staff s ON s.staff_id = cs.conducted_by
             WHERE ca.person_id = :id ORDER BY ca.appointment_datetime DESC', ['id' => $motherId]
        );
    }

    public function fieldVisits(int $motherId): array
    {
        return parent::findAll(
            'SELECT fv.*, CONCAT_WS(" ", s.first_name, s.middle_name, s.last_name) AS staff_name
             FROM field_visit fv INNER JOIN staff s ON s.staff_id = fv.staff_id
             WHERE fv.person_id = :id ORDER BY fv.visit_date DESC', ['id' => $motherId]
        );
    }

    public function supplements(int $motherId): array
    {
        return parent::findAll(
            'SELECT sd.*, sm.supplement_name, sm.unit,
                    CONCAT_WS(" ", s.first_name, s.middle_name, s.last_name) AS staff_name
             FROM supplement_distribution sd INNER JOIN supplement_master sm ON sm.supplement_id = sd.supplement_id
             INNER JOIN staff s ON s.staff_id = sd.distributed_by
             WHERE sd.person_id = :id ORDER BY sd.distribution_date DESC', ['id' => $motherId]
        );
    }

    private function selectSql(): string
    {
        return 'SELECT p.*, p.person_id AS id,
                    CONCAT_WS(" ", p.first_name, p.middle_name, p.last_name) AS full_name,
                    f.registration_number AS family_code, f.address AS family_address,
                    pa.phm_area_name,
                    COUNT(DISTINCT pg.pregnancy_id) AS pregnancy_count,
                    MAX(CASE WHEN pg.current_status = "Ongoing" THEN pg.expected_delivery_date END) AS expected_delivery_date,
                    MAX(CASE WHEN pg.current_status = "Ongoing" THEN pg.risk_status END) AS risk_status,
                    CASE WHEN SUM(pg.current_status = "Ongoing") > 0 THEN "Pregnant" ELSE "Registered" END AS maternal_status,
                    pr.role_name
             FROM person p
             INNER JOIN person_role pr ON pr.person_role_id = p.person_role_id
             INNER JOIN family f ON f.family_id = p.family_id
             INNER JOIN phm_area pa ON pa.phm_area_id = f.phm_area_id
             LEFT JOIN pregnancy pg ON pg.mother_id = p.person_id';
    }
}
