<?php

declare(strict_types=1);

class ChildRepository extends Repository
{
    public function search(string $search = '', int $limit = 100): array
    {
        $sql = $this->baseSelect() . '
            WHERE (:search = "" OR CONCAT_WS(" ", p.first_name, p.middle_name, p.last_name) LIKE :term_name
                OR f.registration_number LIKE :term_family OR p.nic LIKE :term_nic)
            ORDER BY p.date_of_birth DESC
            LIMIT :limit';

        return $this->findAll($sql, [
            'search' => $search,
            'term_name' => '%' . $search . '%',
            'term_family' => '%' . $search . '%',
            'term_nic' => '%' . $search . '%',
            'limit' => $limit,
        ]);
    }

    public function findRecentActivity(int $limitDays): array
    {
        $sql = '
        SELECT
            ch.person_id AS child_id,
            p.first_name,
            p.middle_name,
            p.last_name,
            ch.birth_weight_kg,
            ch.registered_date,
            f.registration_number,
            ch.created_at
        FROM child AS ch
        INNER JOIN person AS p ON p.person_id = ch.person_id
        INNER JOIN family AS f ON f.family_id = p.family_id
        WHERE ch.registered_date >= DATE_SUB(CURDATE(), INTERVAL :limitDays DAY)
        ORDER BY ch.registered_date DESC
    	';
        $params = [
            'limitDays' => $limitDays
        ];

        return $this->findAll($sql, $params);
    }

    public function findRecent(int $limit = 8): array
    {
        return $this->findAll(
            $this->baseSelect() . ' ORDER BY ch.registered_date DESC, ch.person_id DESC LIMIT :limit',
            ['limit' => $limit]
        );
    }

    public function findById(int $childId): ?array
    {
        return $this->findOne(
            $this->baseSelect() . ' WHERE ch.person_id = :child_id LIMIT 1',
            ['child_id' => $childId]
        );
    }

    public function byFamily(int $familyId): array
    {
        return $this->findAll(
            $this->baseSelect() . ' WHERE p.family_id = :family_id ORDER BY p.date_of_birth DESC',
            ['family_id' => $familyId]
        );
    }

    public function statistics(): array
    {
        return $this->findOne(
            'SELECT
                COUNT(*) AS total,
                SUM(TIMESTAMPDIFF(MONTH, p.date_of_birth, CURDATE()) < 12) AS under_one,
                SUM(TIMESTAMPDIFF(YEAR, p.date_of_birth, CURDATE()) < 5) AS under_five,
                SUM(c.special_needs = 1) AS special_needs
             FROM child c
             INNER JOIN person p ON p.person_id = c.person_id'
        ) ?? ['total' => 0, 'under_one' => 0, 'under_five' => 0, 'special_needs' => 0];
    }


    public function countByAgeRange(int $startAgeMonths = 0, int $endAgeMonths = 60): int
    {
        $sql = 'SELECT COUNT(*) FROM child AS c
          INNER JOIN person AS P
          ON c.person_id = p.person_id
          WHERE
            TIMESTAMPDIFF(
                MONTH,
                p.date_of_birth,
                CURDATE()
            ) BETWEEN :startAge AND :endAge';
        $params = [
            ':startAge' => $startAgeMonths,
            ':endAge' => $endAgeMonths
        ];

        return $this->findScalar($sql, $params);
    }

    public function countByRegisteredDate(string $period = 'month'): int
    {
        $sql = 'SELECT COUNT(*) FROM child AS ch';
        switch ($period) {
            case 'week':
                $start = date('Y-m-d', strtotime('monday this week'));
                $end = date('Y-m-d', strtotime('monday next week'));
                break;

            case 'month':
                $start = date('Y-m-d', strtotime('first day of this month'));
                $end = date('Y-m-d', strtotime('first day of next month'));
                break;

            case 'year':
                $start = date('Y-m-d', strtotime('first day of this year'));
                $end = date('Y-m-d', strtotime('first day of next year'));
                break;

            default:
                return (int) $this->findScalar($sql);
        }
        $sql .= ' WHERE ch.registered_date >= :start
              AND ch.registered_date < :end';
        $params = [
            ':start' => $start,
            ':end' => $end
        ];
        return $this->findScalar($sql, $params);
    }

    public function create(array $data): bool
    {
        return $this->execute(
            'INSERT INTO child
                (person_id, birth_outcome_id, birth_weight_kg, birth_length_cm,
                 head_circumference_cm, special_needs, breastfeeding_status,
                 neonatal_complications, registered_date)
             VALUES
                (:person_id, :birth_outcome_id, :birth_weight_kg, :birth_length_cm,
                 :head_circumference_cm, :special_needs, :breastfeeding_status,
                 :neonatal_complications, :registered_date)',
            $this->params($data)
        ) === 1;
    }

    public function update(int $childId, array $data): bool
    {
        $params = $this->params($data);
        unset($params['person_id']);
        $params['child_id'] = $childId;

        $this->execute(
            'UPDATE child SET
                birth_outcome_id = :birth_outcome_id,
                birth_weight_kg = :birth_weight_kg,
                birth_length_cm = :birth_length_cm,
                head_circumference_cm = :head_circumference_cm,
                special_needs = :special_needs,
                breastfeeding_status = :breastfeeding_status,
                neonatal_complications = :neonatal_complications,
                registered_date = :registered_date
             WHERE person_id = :child_id',
            $params
        );

        return true;
    }

    public function archive(int $childId): bool
    {
        // The current schema has no archive/status column on child. Never use
        // person.status = "Deceased" as an archive flag for a living child.
        return false;
    }

    private function params(array $data): array
    {
        $nullable = static fn(string $key): mixed => trim((string) ($data[$key] ?? '')) === ''
            ? null
            : $data[$key];

        return [
            'person_id' => (int) ($data['person_id'] ?? 0),
            'birth_outcome_id' => (int) ($data['birth_outcome_id'] ?? 0),
            'birth_weight_kg' => $nullable('birth_weight_kg'),
            'birth_length_cm' => $nullable('birth_length_cm'),
            'head_circumference_cm' => $nullable('head_circumference_cm'),
            'special_needs' => isset($data['special_needs']) ? 1 : 0,
            'breastfeeding_status' => $nullable('breastfeeding_status'),
            'neonatal_complications' => $nullable('neonatal_complications'),
            'registered_date' => $nullable('registered_date') ?? date('Y-m-d'),
        ];
    }

    private function baseSelect(): string
    {
        return 'SELECT ch.*, p.family_id, p.nic, p.first_name, p.middle_name, p.last_name,
                p.gender, p.date_of_birth, p.phone, p.email, p.status,
                CONCAT_WS(" ", p.first_name, p.middle_name, p.last_name) AS full_name,
                TIMESTAMPDIFF(MONTH, p.date_of_birth, CURDATE()) AS age_months,
                f.registration_number AS family_code, f.address AS family_address,
                bo.delivery_date, bo.delivery_place, bo.delivery_mode, bo.gestational_age_weeks,
                CONCAT_WS(" ", m.first_name, m.middle_name, m.last_name) AS mother_name,
                m.person_id AS mother_id,
                gm.measurement_date, gm.weight_kg, gm.height_cm, gm.growth_status,
                vr.next_due_date AS vaccination_due_date,
                vr.vaccination_status
            FROM child ch
            INNER JOIN person p ON p.person_id = ch.person_id
            INNER JOIN family f ON f.family_id = p.family_id
            INNER JOIN birth_outcome bo ON bo.birth_outcome_id = ch.birth_outcome_id
            INNER JOIN pregnancy pr ON pr.pregnancy_id = bo.pregnancy_id
            INNER JOIN person m ON m.person_id = pr.mother_id
            LEFT JOIN growth_measurement gm ON gm.measurement_id = (
                SELECT gm2.measurement_id FROM growth_measurement gm2
                WHERE gm2.child_id = ch.person_id
                ORDER BY gm2.measurement_date DESC, gm2.measurement_id DESC LIMIT 1
            )
            LEFT JOIN vaccination_record vr ON vr.vaccination_id = (
                SELECT vr2.vaccination_id FROM vaccination_record vr2
                WHERE vr2.child_id = ch.person_id
                ORDER BY vr2.vaccination_date DESC, vr2.vaccination_id DESC LIMIT 1
            )';
    }
}
