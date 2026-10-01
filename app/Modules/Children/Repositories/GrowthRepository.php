<?php

declare(strict_types=1);

class GrowthRepository extends Repository
{

    // gets the latest growth measurements
    // Usedfor: Recent measurement page - NI
    // Dashboard "recent growth checks" widget
    public function recent(int $limit = 100): array
    {
        return $this->findAll(
            $this->selectSql() . ' ORDER BY gm.measurement_date DESC, gm.measurement_id DESC LIMIT :limit',
            ['limit' => $limit]
        );
    }

    // Gets all growth measurements of one child
    // Used for: Child growth history chart.
    public function findByChildId(int $childId): array
    {
        return $this->findAll(
            $this->selectSql() . ' WHERE gm.child_id = :child_id
             ORDER BY gm.measurement_date DESC, gm.measurement_id DESC',
            ['child_id' => $childId]
        );
    }

    // Gets one specific measurement record
    //Used for: Edit/view a measurement
    public function findRecord(int $childId, int $measurementId): ?array
    {
        return $this->findOne(
            $this->selectSql() . ' WHERE gm.child_id = :child_id AND gm.measurement_id = :measurement_id LIMIT 1',
            ['child_id' => $childId, 'measurement_id' => $measurementId]
        );
    }
    // Finds children who are due for growth measurement
    // Growth measurements requiring attention
    public function dueChildren(): array
    {
        return $this->findAll(
            'SELECT c.person_id AS child_id,
                    CONCAT_WS(" ", p.first_name, p.middle_name, p.last_name) AS full_name,
                    p.date_of_birth, f.registration_number AS family_code,
                    MAX(gm.measurement_date) AS last_measurement_date,
                    DATE_ADD(COALESCE(MAX(gm.measurement_date), p.date_of_birth), INTERVAL 1 MONTH) AS next_due_date,
                    CASE WHEN MAX(gm.measurement_date) IS NULL THEN "Never measured"
                         WHEN MAX(gm.measurement_date) < DATE_SUB(CURDATE(), INTERVAL 1 MONTH) THEN "Overdue"
                         ELSE "Due" END AS due_status
             FROM child c
             INNER JOIN person p ON p.person_id = c.person_id
             INNER JOIN family f ON f.family_id = p.family_id
             LEFT JOIN growth_measurement gm ON gm.child_id = c.person_id
             GROUP BY c.person_id, p.first_name, p.middle_name, p.last_name,
                      p.date_of_birth, f.registration_number
             HAVING last_measurement_date IS NULL
                 OR last_measurement_date <= DATE_SUB(CURDATE(), INTERVAL 25 DAY)
             ORDER BY next_due_date'
        );
    }

    // Gets children whose latest growth measurement has an abnormal growth status
    // Used for: Growth alerts page.
    public function alerts(): array
    {
        return $this->findAll(
            $this->selectSql() . '
             INNER JOIN (
                SELECT child_id, MAX(measurement_date) AS latest_date
                FROM growth_measurement GROUP BY child_id
             ) latest ON latest.child_id = gm.child_id AND latest.latest_date = gm.measurement_date
             WHERE gm.growth_status IS NOT NULL AND gm.growth_status <> "Normal"
             ORDER BY gm.measurement_date DESC'
        );
    }

    // count abnormal growth measurements
    public function countGrowthAlerts(): int
    {
        $sql = '
        SELECT COUNT(*)
        FROM growth_measurement AS gm1
          WHERE gm1.measurement_id = (
            SELECT gm2.measurement_id
            FROM growth_measurement AS gm2
            WHERE gm2.child_id = gm1.child_id
            ORDER BY gm2.measurement_date DESC,
                     gm2.measurement_id DESC
            LIMIT 1
        )
        AND gm1.growth_status IS NOT NULL
        AND gm1.growth_status <> "Normal"
        
    ';
        return $this->findScalar($sql);
    }

    // Returns aggregated growth statistics
    // Used for: Growth module dashboard
    public function statistics(): array
    {
        return $this->findOne(
            'SELECT COUNT(*) AS total_measurements,
                    SUM(measurement_date >= DATE_FORMAT(CURDATE(), "%Y-%m-01")) AS measured_this_month,
                    SUM(growth_status = "Normal") AS normal_count,
                    SUM(growth_status IS NOT NULL AND growth_status <> "Normal") AS alert_count
             FROM growth_measurement'
        ) ?? [];
    }

    // Gets active staff members
    // Used for: "Measured by" dropdown when recording growth
    public function staffOptions(): array
    {
        return $this->findAll(
            'SELECT staff_id, employee_number,
                    CONCAT_WS(" ", first_name, middle_name, last_name) AS full_name
             FROM staff WHERE status = "Active" ORDER BY full_name'
        );
    }

    // Insert a new growth measurement
    public function create(int $childId, array $data): int
    {   //TEST
        //dd($data);

        $this->execute(
            'INSERT INTO growth_measurement
                (child_id, measured_by, measurement_date, age_in_days, age_in_months, weight_kg,
                 height_cm, head_circumference_cm, muac_cm, bmi,
                 weight_for_age_z_score, height_for_age_z_score,
                 weight_for_height_z_score, growth_status, remarks)
             VALUES
                (:child_id, :measured_by, :measurement_date, :age_in_days, :age_in_months, :weight_kg,
                 :height_cm, :head_circumference_cm, :muac_cm, :bmi,
                 :weight_for_age_z_score, :height_for_age_z_score,
                 :weight_for_height_z_score, :growth_status, :remarks)',
            ['child_id' => $childId] + $this->params($data)
        );
        return $this->lastInsertId();
    }

    // Updates an existing growth record
    public function update(int $childId, int $measurementId, array $data): bool
    {
        $this->execute(
            'UPDATE growth_measurement SET
                measured_by = :measured_by, measurement_date = :measurement_date,
                age_in_days = :age_in_days, weight_kg = :weight_kg, height_cm = :height_cm,
                head_circumference_cm = :head_circumference_cm, muac_cm = :muac_cm,
                bmi = :bmi, weight_for_age_z_score = :weight_for_age_z_score,
                height_for_age_z_score = :height_for_age_z_score,
                weight_for_height_z_score = :weight_for_height_z_score,
                growth_status = :growth_status, remarks = :remarks
             WHERE child_id = :child_id AND measurement_id = :measurement_id',
            $this->params($data) + ['child_id' => $childId, 'measurement_id' => $measurementId]
        );
        return true;
    }




    // Formats input before database insertion/update
    private function params(array $data): array
    {
        $nullable = static fn(string $key): mixed => trim((string) ($data[$key] ?? '')) === '' ? null : $data[$key];
        return [
            'measured_by' => (int) ($data['measured_by'] ?? 0),
            'measurement_date' => $data['measurement_date'] ?? '',
            'age_in_days' => (int) ($data['age_in_days'] ?? 0),
            'age_in_months' => (int) ($data['age_in_months'] ?? 0),
            'weight_kg' => $nullable('weight_kg'),
            'height_cm' => $nullable('height_cm'),
            'head_circumference_cm' => $nullable('head_circumference_cm'),
            'muac_cm' => $nullable('muac_cm'),
            'bmi' => $nullable('bmi'),
            'weight_for_age_z_score' => $nullable('weight_for_age_z_score'),
            'height_for_age_z_score' => $nullable('height_for_age_z_score'),
            'weight_for_height_z_score' => $nullable('weight_for_height_z_score'),
            'growth_status' => $nullable('growth_status'),
            'remarks' => $nullable('remarks'),
        ];
    }

    // Reusable SELECT query
    private function selectSql(): string
    {
        return 'SELECT gm.*,
                TIMESTAMPDIFF(
                    MONTH,
                    p.date_of_birth,
                    gm.measurement_date
                ) AS chart_age_months,
                CONCAT_WS(" ", p.first_name, p.middle_name, p.last_name) AS child_name,
                p.date_of_birth, f.registration_number AS family_code,
                CONCAT_WS(" ", s.first_name, s.middle_name, s.last_name) AS measured_by_name
             FROM growth_measurement gm
             INNER JOIN child c ON c.person_id = gm.child_id
             INNER JOIN person p ON p.person_id = c.person_id
             INNER JOIN family f ON f.family_id = p.family_id
             INNER JOIN staff s ON s.staff_id = gm.measured_by';
    }
}
