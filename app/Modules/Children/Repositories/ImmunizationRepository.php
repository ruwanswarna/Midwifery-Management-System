<?php

declare(strict_types=1);

class ImmunizationRepository extends Repository
{
    public function recent(int $limit = 100): array
    {
        return $this->findAll($this->selectSql() . ' ORDER BY vr.vaccination_date DESC LIMIT :limit', ['limit' => $limit]);
    }

    public function byChild(int $childId): array
    {
        return $this->findAll($this->selectSql() . ' WHERE vr.child_id = :child_id ORDER BY vr.vaccination_date DESC', ['child_id' => $childId]);
    }

    public function scheduleForChild(int $childId): array
    {
        return $this->findAll(
            'SELECT vs.schedule_id, vm.vaccine_name, vs.dose_number, vs.recommended_age_months,
                    vs.description, DATE_ADD(p.date_of_birth, INTERVAL vs.recommended_age_months MONTH) AS due_date,
                    vr.vaccination_id, vr.vaccination_date, vr.vaccination_status,
                    vr.batch_number, vr.adverse_event_reported,
                    CASE WHEN vr.vaccination_id IS NOT NULL THEN vr.vaccination_status
                         WHEN DATE_ADD(p.date_of_birth, INTERVAL vs.recommended_age_months MONTH) < CURDATE() THEN "Overdue"
                         WHEN DATE_ADD(p.date_of_birth, INTERVAL vs.recommended_age_months MONTH) <= DATE_ADD(CURDATE(), INTERVAL 30 DAY) THEN "Due Soon"
                         ELSE "Scheduled" END AS schedule_status
             FROM child c
             INNER JOIN person p ON p.person_id = c.person_id
             CROSS JOIN vaccine_schedule vs
             INNER JOIN vaccine_master vm ON vm.vaccine_id = vs.vaccine_id
             LEFT JOIN vaccination_record vr ON vr.child_id = c.person_id AND vr.schedule_id = vs.schedule_id
             WHERE c.person_id = :child_id AND vm.is_active = 1
             ORDER BY vs.recommended_age_months, vm.vaccine_name, vs.dose_number',
            ['child_id' => $childId]
        );
    }

    public function findRecord(int $childId, int $recordId): ?array
    {
        return $this->findOne($this->selectSql() . ' WHERE vr.child_id = :child_id AND vr.vaccination_id = :record_id LIMIT 1', ['child_id' => $childId, 'record_id' => $recordId]);
    }

    public function dueChildren(): array
    {
        return $this->findAll(
            'SELECT c.person_id AS child_id,
                    CONCAT_WS(" ", p.first_name, p.middle_name, p.last_name) AS child_name,
                    f.registration_number AS family_code, vm.vaccine_name, vs.dose_number,
                    DATE_ADD(p.date_of_birth, INTERVAL vs.recommended_age_months MONTH) AS due_date,
                    CASE WHEN DATE_ADD(p.date_of_birth, INTERVAL vs.recommended_age_months MONTH) < CURDATE() THEN "Overdue" ELSE "Due Soon" END AS due_status
             FROM child c
             INNER JOIN person p ON p.person_id = c.person_id
             INNER JOIN family f ON f.family_id = p.family_id
             CROSS JOIN vaccine_schedule vs
             INNER JOIN vaccine_master vm ON vm.vaccine_id = vs.vaccine_id
             LEFT JOIN vaccination_record vr ON vr.child_id = c.person_id AND vr.schedule_id = vs.schedule_id
             WHERE vr.vaccination_id IS NULL
               AND DATE_ADD(p.date_of_birth, INTERVAL vs.recommended_age_months MONTH) <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)
             ORDER BY due_date'
        );
    }

    public function alerts(): array
    {
        return $this->findAll(
            $this->selectSql() . '
             WHERE vr.vaccination_status IN ("Delayed", "Missed", "Contraindicated")
                OR vr.adverse_event_reported = 1
             ORDER BY vr.vaccination_date DESC'
        );
    }

    public function statistics(): array
    {
        return $this->findOne(
            'SELECT COUNT(*) AS administered,
                    SUM(vaccination_date >= DATE_FORMAT(CURDATE(), "%Y-%m-01")) AS administered_this_month,
                    SUM(vaccination_status = "Delayed") AS delayed_count,
                    SUM(vaccination_status = "Missed") AS missed_count,
                    SUM(adverse_event_reported = 1) AS adverse_event_count
             FROM vaccination_record'
        ) ?? [];
    }

    public function scheduleOptions(): array
    {
        return $this->findAll(
            'SELECT vs.schedule_id, vm.vaccine_name, vs.dose_number, vs.description
             FROM vaccine_schedule vs INNER JOIN vaccine_master vm ON vm.vaccine_id = vs.vaccine_id
             WHERE vm.is_active = 1 ORDER BY vs.recommended_age_months, vm.vaccine_name'
        );
    }

    public function staffOptions(): array
    {
        return $this->findAll('SELECT staff_id, CONCAT_WS(" ", first_name, middle_name, last_name) AS full_name FROM staff WHERE status = "Active" ORDER BY full_name');
    }

    public function create(int $childId, array $data): int
    {
        $this->execute(
            'INSERT INTO vaccination_record
                (child_id, schedule_id, administered_by, vaccination_date, batch_number,
                 next_due_date, vaccination_status, adverse_event_reported, side_effects, remarks)
             VALUES (:child_id, :schedule_id, :administered_by, :vaccination_date, :batch_number,
                 :next_due_date, :vaccination_status, :adverse_event_reported, :side_effects, :remarks)',
            ['child_id' => $childId] + $this->params($data)
        );
        return $this->lastInsertId();
    }

    public function update(int $childId, int $recordId, array $data): bool
    {
        $this->execute(
            'UPDATE vaccination_record SET schedule_id = :schedule_id,
                administered_by = :administered_by, vaccination_date = :vaccination_date,
                batch_number = :batch_number, next_due_date = :next_due_date,
                vaccination_status = :vaccination_status,
                adverse_event_reported = :adverse_event_reported,
                side_effects = :side_effects, remarks = :remarks
             WHERE child_id = :child_id AND vaccination_id = :record_id',
            $this->params($data) + ['child_id' => $childId, 'record_id' => $recordId]
        );
        return true;
    }

    private function params(array $data): array
    {
        $nullable = static fn (string $key): ?string => trim((string) ($data[$key] ?? '')) ?: null;
        return [
            'schedule_id' => (int) ($data['schedule_id'] ?? 0),
            'administered_by' => (int) ($data['administered_by'] ?? 0),
            'vaccination_date' => $data['vaccination_date'] ?? '',
            'batch_number' => $nullable('batch_number'),
            'next_due_date' => $nullable('next_due_date'),
            'vaccination_status' => $data['vaccination_status'] ?? 'Completed',
            'adverse_event_reported' => isset($data['adverse_event_reported']) ? 1 : 0,
            'side_effects' => $nullable('side_effects'),
            'remarks' => $nullable('remarks'),
        ];
    }

    private function selectSql(): string
    {
        return 'SELECT vr.*, vm.vaccine_name, vs.dose_number, vs.description AS schedule_description,
                    CONCAT_WS(" ", p.first_name, p.middle_name, p.last_name) AS child_name,
                    f.registration_number AS family_code,
                    CONCAT_WS(" ", s.first_name, s.middle_name, s.last_name) AS administered_by_name
             FROM vaccination_record vr
             INNER JOIN child c ON c.person_id = vr.child_id
             INNER JOIN person p ON p.person_id = c.person_id
             INNER JOIN family f ON f.family_id = p.family_id
             INNER JOIN vaccine_schedule vs ON vs.schedule_id = vr.schedule_id
             INNER JOIN vaccine_master vm ON vm.vaccine_id = vs.vaccine_id
             INNER JOIN staff s ON s.staff_id = vr.administered_by';
    }
}
