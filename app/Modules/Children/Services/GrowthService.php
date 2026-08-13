<?php

declare(strict_types=1);

class GrowthService
{
    private GrowthRepository $repository;

    public function __construct()
    {
        $this->repository = new GrowthRepository();
    }

    public function getAll(): array
    {
        return $this->repository->recent();
    }
    public function getByChildId(int $id): array
    {   dd($this->repository->findByChildId($id));
        return $this->repository->findByChildId($id);
    }
    public function findRecord(int $childId, int $id): ?array
    {
        return $this->repository->findRecord($childId, $id);
    }
    public function getDueChildren(): array
    {
        return $this->repository->dueChildren();
    }
    public function getActiveAlerts(): array
    {
        return $this->repository->alerts();
    }
    public function getStatistics(): array
    {
        return $this->repository->statistics();
    }
    public function getStaffOptions(): array
    {
        return $this->repository->staffOptions();
    }

    public function create(int $childId, array $data): ?int
    {
        if (!$this->validate($data)) return null;
        return $this->repository->create($childId, $data);
    }

    public function update(int $childId, int $measurementId, array $data): bool
    {
        if ($this->repository->findRecord($childId, $measurementId) === null || !$this->validate($data)) return false;
        return $this->repository->update($childId, $measurementId, $data);
    }

    private function validate(array $data): bool
    {
        $errors = [];
        foreach (['measured_by' => 'Select the staff member who measured the child.', 'measurement_date' => 'Measurement date is required.', 'age_in_days' => 'Age in days is required.'] as $field => $message) {
            if (trim((string) ($data[$field] ?? '')) === '') $errors[$field] = $message;
        }
        if ((int) ($data['measured_by'] ?? 0) < 1) $errors['measured_by'] = 'Select a valid staff member.';
        if ((int) ($data['age_in_days'] ?? -1) < 0) $errors['age_in_days'] = 'Age in days cannot be negative.';
        foreach (['weight_kg', 'height_cm', 'head_circumference_cm', 'muac_cm', 'bmi'] as $field) {
            $value = trim((string) ($data[$field] ?? ''));
            if ($value !== '' && (!is_numeric($value) || (float) $value < 0)) $errors[$field] = 'Enter a valid non-negative value.';
        }
        $statuses = ['Normal', 'Underweight', 'Severely Underweight', 'Stunted', 'Severely Stunted', 'Wasted', 'Severely Wasted', 'Overweight'];
        if (!empty($data['growth_status']) && !in_array($data['growth_status'], $statuses, true)) $errors['growth_status'] = 'Select a valid growth status.';
        if ($errors !== []) {
            $_SESSION['errors'] = $errors;
            $_SESSION['growthData'] = $data;
            return false;
        }
        return true;
    }
}
