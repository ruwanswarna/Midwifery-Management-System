<?php

declare(strict_types=1);

class PregnancyRepository extends Repository
{
    public function search(string $search = '', ?string $status = null, int $limit = 100): array
    {
        return $this->findAll(
            $this->selectSql() . '
             WHERE (:search = "" OR CONCAT_WS(" ", m.first_name, m.middle_name, m.last_name) LIKE :term_name
                    OR m.nic LIKE :term_nic OR f.registration_number LIKE :term_family)
               AND (:status_null IS NULL OR pg.current_status = :status_value)
             ORDER BY pg.expected_delivery_date, pg.pregnancy_id DESC LIMIT :limit',
            ['search' => $search, 'term_name' => '%' . $search . '%', 'term_nic' => '%' . $search . '%', 'term_family' => '%' . $search . '%', 'status_null' => $status, 'status_value' => $status, 'limit' => $limit]
        );
    }

    // find recent pregnancies registered within the last $limitDays days
    public function findRecentActivity(int $limitDays): array
    {
        $sql = '
        SELECT
            pg.pregnancy_id,
            pg.mother_id,
            pg.registered_date,
            pg.expected_delivery_date,
            p.family_id,
            p.first_name,
            p.middle_name,
            p.last_name,
            p.nic,
            f.registration_number,
            pg.created_at
        FROM pregnancy AS pg
        INNER JOIN person AS p ON p.person_id = pg.mother_id
        INNER JOIN family AS f ON f.family_id = p.family_id
        WHERE pg.registered_date >= DATE_SUB(CURDATE(), INTERVAL :limitDays DAY)
        ORDER BY pg.registered_date DESC
    	';
        $params = [
            'limitDays' => $limitDays
        ];

        return $this->findAll($sql, $params);
    }

    public function findById(int $id): ?array
    {
        return $this->findOne($this->selectSql() . ' WHERE pg.pregnancy_id = :id LIMIT 1', ['id' => $id]);
    }

    public function mothers(): array
    {
        return $this->findAll(
            'SELECT p.person_id AS mother_id, CONCAT_WS(" ", p.first_name, p.middle_name, p.last_name) AS full_name,
                    p.nic, f.registration_number AS family_code
             FROM person p INNER JOIN person_role pr ON pr.person_role_id = p.person_role_id
             INNER JOIN family f ON f.family_id = p.family_id
             WHERE pr.role_name = "Mother" AND p.status = "Active"
             ORDER BY full_name'
        );
    }

    public function create(array $data): int
    {
        $this->execute(
            'INSERT INTO pregnancy
                (mother_id, registered_date, booking_date, last_menstrual_period,
                 expected_delivery_date, pregnancy_age_at_registration, gravida, para,
                 abortions, living_children, bmi_at_booking, hemoglobin_level,
                 blood_pressure, pregnancy_type, risk_status, current_status, remarks)
             VALUES (:mother_id, :registered_date, :booking_date, :last_menstrual_period,
                 :expected_delivery_date, :pregnancy_age_at_registration, :gravida, :para,
                 :abortions, :living_children, :bmi_at_booking, :hemoglobin_level,
                 :blood_pressure, :pregnancy_type, :risk_status, :current_status, :remarks)',
            $this->params($data)
        );
        return $this->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $this->execute(
            'UPDATE pregnancy SET mother_id = :mother_id, registered_date = :registered_date,
                booking_date = :booking_date, last_menstrual_period = :last_menstrual_period,
                expected_delivery_date = :expected_delivery_date,
                pregnancy_age_at_registration = :pregnancy_age_at_registration,
                gravida = :gravida, para = :para, abortions = :abortions,
                living_children = :living_children, bmi_at_booking = :bmi_at_booking,
                hemoglobin_level = :hemoglobin_level, blood_pressure = :blood_pressure,
                pregnancy_type = :pregnancy_type, risk_status = :risk_status,
                current_status = :current_status, remarks = :remarks
             WHERE pregnancy_id = :id',
            $this->params($data) + ['id' => $id]
        );
        return true;
    }

    public function delete(int $id): bool
    {
        return $this->execute('DELETE FROM pregnancy WHERE pregnancy_id = :id', ['id' => $id]) === 1;
    }

    public function highRisk(): array
    {
        return $this->findAll($this->selectSql() . ' WHERE pg.current_status = "Ongoing" AND pg.risk_status = "High" ORDER BY pg.expected_delivery_date');
    }

    public function expectedDeliveries(int $days = 60): array
    {
        $days = max(1, min($days, 365));
        return $this->findAll(
            $this->selectSql() . ' WHERE pg.current_status = "Ongoing" AND pg.expected_delivery_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL ' . $days . ' DAY) ORDER BY pg.expected_delivery_date'
        );
    }

    public function countDueSoon(int $days = 14): int
    {
        $maximumAllowedDays = 210;
        $days = max(1, min($days, $maximumAllowedDays));
        $sql = 'SELECT COUNT(*)
            FROM pregnancy AS pg
            WHERE pg.current_status = "Ongoing"
            AND pg.expected_delivery_date
                BETWEEN CURDATE()
                AND DATE_ADD(CURDATE(), INTERVAL ' . $days . ' DAY)';

        return $this->findScalar($sql);
    }

    public function visits(): array
    {
        return $this->findAll(
            'SELECT fv.*, pg.expected_delivery_date, pg.risk_status,
                    CONCAT_WS(" ", m.first_name, m.middle_name, m.last_name) AS mother_name,
                    CONCAT_WS(" ", s.first_name, s.middle_name, s.last_name) AS staff_name
             FROM field_visit fv INNER JOIN pregnancy pg ON pg.pregnancy_id = fv.pregnancy_id
             INNER JOIN person m ON m.person_id = pg.mother_id INNER JOIN staff s ON s.staff_id = fv.staff_id
             ORDER BY COALESCE(fv.follow_up_date, fv.visit_date)'
        );
    }

    public function birthOutcomes(): array
    {
        return $this->findAll(
            'SELECT bo.*, pg.mother_id,
                    CONCAT_WS(" ", m.first_name, m.middle_name, m.last_name) AS mother_name,
                    COUNT(c.person_id) AS registered_children
             FROM birth_outcome bo INNER JOIN pregnancy pg ON pg.pregnancy_id = bo.pregnancy_id
             INNER JOIN person m ON m.person_id = pg.mother_id
             LEFT JOIN child c ON c.birth_outcome_id = bo.birth_outcome_id
             GROUP BY bo.birth_outcome_id ORDER BY bo.delivery_date DESC'
        );
    }

    public function statistics(): array
    {
        return $this->findOne(
            'SELECT COUNT(*) AS total,
                    SUM(current_status = "Ongoing") AS ongoing,
                    SUM(current_status = "Ongoing" AND risk_status = "High") AS high_risk,
                    SUM(current_status = "Ongoing" AND expected_delivery_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)) AS deliveries_due,
                    SUM(current_status = "Delivered") AS delivered
             FROM pregnancy'
        ) ?? [];
    }

    public function createBirthOutcome(int $pregnancyId, array $data): int
    {
        $this->execute(
            'INSERT INTO birth_outcome
                (pregnancy_id, outcome_type, delivery_date, delivery_place, delivery_mode,
                 gestational_age_weeks, mother_status, complications, notes)
             VALUES (:pregnancy_id, :outcome_type, :delivery_date, :delivery_place, :delivery_mode,
                 :gestational_age_weeks, :mother_status, :complications, :notes)',
            [
                'pregnancy_id' => $pregnancyId,
                'outcome_type' => $data['outcome_type'],
                'delivery_date' => $data['delivery_date'],
                'delivery_place' => trim((string) ($data['delivery_place'] ?? '')) ?: null,
                'delivery_mode' => trim((string) ($data['delivery_mode'] ?? '')) ?: null,
                'gestational_age_weeks' => trim((string) ($data['gestational_age_weeks'] ?? '')) ?: null,
                'mother_status' => trim((string) ($data['mother_status'] ?? '')) ?: null,
                'complications' => trim((string) ($data['complications'] ?? '')) ?: null,
                'notes' => trim((string) ($data['notes'] ?? '')) ?: null,
            ]
        );
        $outcomeId = $this->lastInsertId();

        $this->execute('UPDATE pregnancy SET current_status = :status WHERE pregnancy_id = :id', [
            'status' => in_array($data['outcome_type'], ['Live Birth', 'Live Birth - Expired', 'Still Birth'], true) ? 'Delivered' : 'Terminated',
            'id' => $pregnancyId,
        ]);
        return $outcomeId;
    }


    // $type-> 'active', 'high-risk', 'all'
    public function countPregnancy(string $type = 'all', ?string $period = null, bool $prevPeriod = false): int
    {
        $sql = 'SELECT COUNT(*) FROM pregnancy';
        $params = [];
        $hasWhere = false;

        switch ($type) {
            case 'active':
                $sql .= " WHERE current_status = 'Ongoing'";
                $hasWhere = true;
                break;

            case 'high-risk':
                $sql .= " WHERE current_status = 'Ongoing'
                AND risk_status = 'High'";
                $hasWhere = true;
                break;

            case 'all':
            default:
                break;
        }

        if ($period !== null) {
            $start = null;
            $end = null;
            switch ($period) {
                case 'week':
                    $start = $prevPeriod
                        ? date('Y-m-d', strtotime('monday last week')) : date('Y-m-d', strtotime('monday this week'));
                    $end = $prevPeriod
                        ? date('Y-m-d', strtotime('monday this week')) : date('Y-m-d', strtotime('monday next week'));
                    break;
                case 'month':
                    $start = $prevPeriod
                        ? date('Y-m-d', strtotime('first day of last month'))
                        : date('Y-m-d', strtotime('first day of this month'));

                    $end = $prevPeriod
                        ? date('Y-m-d', strtotime('first day of this month'))
                        : date('Y-m-d', strtotime('first day of next month'));
                    break;
                case 'year':
                    $start = $prevPeriod
                        ? date('Y-m-d', strtotime('first day of last year'))
                        : date('Y-m-d', strtotime('first day of this year'));

                    $end = $prevPeriod
                        ? date('Y-m-d', strtotime('first day of this year'))
                        : date('Y-m-d', strtotime('first day of next year'));
                    break;

                default:
                    return $this->findScalar($sql);
            }
            $sql .= $hasWhere ? 'AND' : ' WHERE';
            $sql .= ' registered_date >= :start AND registered_date < :end';
            $params = [
                ':start' => $start,
                ':end' => $end
            ];
            return $this->findScalar($sql, $params);
        }

        return $this->findScalar($sql, $params);
    }

    // count highrisk pregnancies that need follow up visits
    public function countHighRiskFollowup(): int
    {
        $sql = 'SELECT COUNT(*)
            FROM pregnancy AS pr
            INNER JOIN field_visit AS fv
            ON pr.pregnancy_id = fv.pregnancy_id
            WHERE current_status = "Ongoing"
              AND risk_status = "High"
              AND follow_up_required > 0';

        return (int) $this->findScalar($sql);
    }

    private function params(array $data): array
    {
        $nullable = static fn(string $key): mixed => trim((string) ($data[$key] ?? '')) === '' ? null : $data[$key];
        return [
            'mother_id' => (int) ($data['mother_id'] ?? 0),
            'registered_date' => $data['registered_date'] ?? date('Y-m-d'),
            'booking_date' => $nullable('booking_date'),
            'last_menstrual_period' => $data['last_menstrual_period'] ?? '',
            'expected_delivery_date' => $data['expected_delivery_date'] ?? '',
            'pregnancy_age_at_registration' => $nullable('pregnancy_age_at_registration'),
            'gravida' => $nullable('gravida'),
            'para' => $nullable('para'),
            'abortions' => $nullable('abortions') ?? 0,
            'living_children' => $nullable('living_children') ?? 0,
            'bmi_at_booking' => $nullable('bmi_at_booking'),
            'hemoglobin_level' => $nullable('hemoglobin_level'),
            'blood_pressure' => $nullable('blood_pressure'),
            'pregnancy_type' => $data['pregnancy_type'] ?? 'Singleton',
            'risk_status' => $data['risk_status'] ?? 'Low',
            'current_status' => $data['current_status'] ?? 'Ongoing',
            'remarks' => $nullable('remarks'),
        ];
    }

    private function selectSql(): string
    {
        return 'SELECT pg.*, pg.registered_date AS registration_date,
                    CONCAT_WS(" ", m.first_name, m.middle_name, m.last_name) AS mother_name,
                    m.nic, m.phone, f.registration_number AS family_code,
                    pa.phm_area_name,
                    bo.birth_outcome_id, bo.outcome_type, bo.delivery_date
             FROM pregnancy pg INNER JOIN person m ON m.person_id = pg.mother_id
             INNER JOIN family f ON f.family_id = m.family_id
             INNER JOIN phm_area pa ON pa.phm_area_id = f.phm_area_id
             LEFT JOIN birth_outcome bo ON bo.birth_outcome_id = (
                SELECT bo2.birth_outcome_id FROM birth_outcome bo2
                WHERE bo2.pregnancy_id = pg.pregnancy_id
                ORDER BY bo2.delivery_date DESC, bo2.birth_outcome_id DESC LIMIT 1
             )';
    }
}
