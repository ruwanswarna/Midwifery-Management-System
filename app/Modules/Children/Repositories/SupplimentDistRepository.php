<?php

declare(strict_types=1);

class SupplimentDistRepository extends Repository
{
    public function recent(?string $recipientType = null, int $limit = 100): array
    {
        $where = $recipientType === null ? '' : ' WHERE sd.recipient_type = :recipient_type';
        $params = $recipientType === null ? [] : ['recipient_type' => $recipientType];
        $params['limit'] = $limit;
        return $this->findAll($this->selectSql() . $where . ' ORDER BY sd.distribution_date DESC, sd.distribution_id DESC LIMIT :limit', $params);
    }

    public function byPerson(int $personId): array
    {
        return $this->findAll($this->selectSql() . ' WHERE sd.person_id = :person_id ORDER BY sd.distribution_date DESC', ['person_id' => $personId]);
    }

    public function findRecord(int $personId, int $distributionId): ?array
    {
        return $this->findOne($this->selectSql() . ' WHERE sd.person_id = :person_id AND sd.distribution_id = :distribution_id LIMIT 1', ['person_id' => $personId, 'distribution_id' => $distributionId]);
    }

    public function findById(int $distributionId): ?array
    {
        return $this->findOne($this->selectSql() . ' WHERE sd.distribution_id = :distribution_id LIMIT 1', ['distribution_id' => $distributionId]);
    }

    public function delete(int $distributionId): bool
    {
        return $this->execute('DELETE FROM supplement_distribution WHERE distribution_id = :id', ['id' => $distributionId]) === 1;
    }

    public function due(?string $recipientType = null): array
    {
        $typeSql = $recipientType === null ? '' : ' AND sd.recipient_type = :recipient_type';
        $params = $recipientType === null ? [] : ['recipient_type' => $recipientType];
        return $this->findAll(
            $this->selectSql() . '
             WHERE sd.next_distribution_due IS NOT NULL
               AND sd.next_distribution_due <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)' . $typeSql . '
               AND sd.distribution_id = (
                   SELECT sd2.distribution_id FROM supplement_distribution sd2
                   WHERE sd2.person_id = sd.person_id AND sd2.supplement_id = sd.supplement_id
                   ORDER BY sd2.distribution_date DESC, sd2.distribution_id DESC LIMIT 1
               )
             ORDER BY sd.next_distribution_due',
            $params
        );
    }

    public function statistics(): array
    {
        return $this->findOne(
            'SELECT COUNT(*) AS total_distributions,
                    SUM(distribution_date >= DATE_FORMAT(CURDATE(), "%Y-%m-01")) AS distributed_this_month,
                    SUM(next_distribution_due BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)) AS due_count,
                    SUM(next_distribution_due < CURDATE()) AS overdue_count
             FROM supplement_distribution'
        ) ?? [];
    }

    public function supplementOptions(string $recipientType): array
    {
        return $this->findAll(
            'SELECT supplement_id, supplement_name, dosage, unit, frequency, target_group
             FROM supplement_master
             WHERE is_active = 1 AND target_group IN (:recipient_type, "General")
             ORDER BY supplement_name',
            ['recipient_type' => $recipientType]
        );
    }

    public function staffOptions(): array
    {
        return $this->findAll('SELECT staff_id, CONCAT_WS(" ", first_name, middle_name, last_name) AS full_name FROM staff WHERE status = "Active" ORDER BY full_name');
    }

    public function create(int $personId, string $recipientType, array $data): int
    {
        $this->execute(
            'INSERT INTO supplement_distribution
                (person_id, supplement_id, distributed_by, recipient_type, distribution_date,
                 quantity, expiry_date, next_distribution_due, remarks)
             VALUES (:person_id, :supplement_id, :distributed_by, :recipient_type, :distribution_date,
                 :quantity, :expiry_date, :next_distribution_due, :remarks)',
            ['person_id' => $personId, 'recipient_type' => $recipientType] + $this->params($data)
        );
        return $this->lastInsertId();
    }

    public function update(int $personId, int $distributionId, array $data): bool
    {
        $this->execute(
            'UPDATE supplement_distribution SET supplement_id = :supplement_id,
                distributed_by = :distributed_by, distribution_date = :distribution_date,
                quantity = :quantity, expiry_date = :expiry_date,
                next_distribution_due = :next_distribution_due, remarks = :remarks
             WHERE person_id = :person_id AND distribution_id = :distribution_id',
            $this->params($data) + ['person_id' => $personId, 'distribution_id' => $distributionId]
        );
        return true;
    }

    private function params(array $data): array
    {
        $nullable = static fn (string $key): ?string => trim((string) ($data[$key] ?? '')) ?: null;
        return [
            'supplement_id' => (int) ($data['supplement_id'] ?? 0),
            'distributed_by' => (int) ($data['distributed_by'] ?? 0),
            'distribution_date' => $data['distribution_date'] ?? '',
            'quantity' => $data['quantity'] ?? 0,
            'expiry_date' => $nullable('expiry_date'),
            'next_distribution_due' => $nullable('next_distribution_due'),
            'remarks' => $nullable('remarks'),
        ];
    }

    private function selectSql(): string
    {
        return 'SELECT sd.*, sm.supplement_name, sm.unit, sm.dosage, sm.frequency,
                    CONCAT_WS(" ", p.first_name, p.middle_name, p.last_name) AS recipient_name,
                    p.date_of_birth, f.registration_number AS family_code,
                    CONCAT_WS(" ", s.first_name, s.middle_name, s.last_name) AS distributed_by_name,
                    CASE WHEN sd.next_distribution_due < CURDATE() THEN "Overdue"
                         WHEN sd.next_distribution_due <= DATE_ADD(CURDATE(), INTERVAL 30 DAY) THEN "Due Soon"
                         ELSE "Current" END AS due_status
             FROM supplement_distribution sd
             INNER JOIN supplement_master sm ON sm.supplement_id = sd.supplement_id
             INNER JOIN person p ON p.person_id = sd.person_id
             INNER JOIN family f ON f.family_id = p.family_id
             INNER JOIN staff s ON s.staff_id = sd.distributed_by';
    }
}
