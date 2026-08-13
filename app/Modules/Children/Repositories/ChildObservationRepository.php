<?php

declare(strict_types=1);

class ChildObservationRepository extends Repository
{
    public function recent(int $limit = 100): array
    {
        return $this->findAll($this->selectSql() . ' ORDER BY o.observation_date DESC LIMIT :limit', ['limit' => $limit]);
    }

    public function byChild(int $childId): array
    {
        return $this->findAll($this->selectSql() . ' WHERE o.child_id = :child_id ORDER BY o.observation_date DESC', ['child_id' => $childId]);
    }

    public function findRecord(int $childId, int $observationId): ?array
    {
        return $this->findOne($this->selectSql() . ' WHERE o.child_id = :child_id AND o.observation_id = :observation_id LIMIT 1', ['child_id' => $childId, 'observation_id' => $observationId]);
    }

    public function alerts(): array
    {
        return $this->findAll($this->selectSql() . ' WHERE o.observation_status IN ("Delayed", "Not Achieved") OR o.follow_up_required = 1 ORDER BY o.follow_up_date, o.observation_date DESC');
    }

    public function findMilestones(): array
    {
        return $this->findAll('SELECT * FROM development_milestone WHERE is_active = 1 ORDER BY expected_age_from_month, milestone_category, milestone_name');
    }

    public function staffOptions(): array
    {
        return $this->findAll('SELECT staff_id, CONCAT_WS(" ", first_name, middle_name, last_name) AS full_name FROM staff WHERE status = "Active" ORDER BY full_name');
    }

    public function create(int $childId, array $data): int
    {
        $this->execute(
            'INSERT INTO child_development_observation
                (child_id, milestone_id, observed_by, observation_date, observation_status,
                 follow_up_required, follow_up_date, remarks)
             VALUES (:child_id, :milestone_id, :observed_by, :observation_date, :observation_status,
                 :follow_up_required, :follow_up_date, :remarks)',
            ['child_id' => $childId] + $this->params($data)
        );
        return $this->lastInsertId();
    }

    public function update(int $childId, int $observationId, array $data): bool
    {
        $this->execute(
            'UPDATE child_development_observation SET milestone_id = :milestone_id,
                observed_by = :observed_by, observation_date = :observation_date,
                observation_status = :observation_status, follow_up_required = :follow_up_required,
                follow_up_date = :follow_up_date, remarks = :remarks
             WHERE child_id = :child_id AND observation_id = :observation_id',
            $this->params($data) + ['child_id' => $childId, 'observation_id' => $observationId]
        );
        return true;
    }

    private function params(array $data): array
    {
        return [
            'milestone_id' => (int) ($data['milestone_id'] ?? 0),
            'observed_by' => (int) ($data['observed_by'] ?? 0),
            'observation_date' => $data['observation_date'] ?? '',
            'observation_status' => $data['observation_status'] ?? '',
            'follow_up_required' => isset($data['follow_up_required']) ? 1 : 0,
            'follow_up_date' => trim((string) ($data['follow_up_date'] ?? '')) ?: null,
            'remarks' => trim((string) ($data['remarks'] ?? '')) ?: null,
        ];
    }

    private function selectSql(): string
    {
        return 'SELECT o.*, dm.milestone_name, dm.milestone_category,
                    dm.expected_age_from_month, dm.expected_age_to_month,
                    CONCAT_WS(" ", p.first_name, p.middle_name, p.last_name) AS child_name,
                    f.registration_number AS family_code,
                    CONCAT_WS(" ", s.first_name, s.middle_name, s.last_name) AS observed_by_name
             FROM child_development_observation o
             INNER JOIN development_milestone dm ON dm.milestone_id = o.milestone_id
             INNER JOIN person p ON p.person_id = o.child_id
             INNER JOIN family f ON f.family_id = p.family_id
             INNER JOIN staff s ON s.staff_id = o.observed_by';
    }
}
