<?php

declare(strict_types=1);

class ImmunizationService
{
    private ImmunizationRepository $repository;
    public function __construct()
    {
        $this->repository = new ImmunizationRepository();
    }

    public function getAll(): array
    {
        return $this->repository->recent();
    }
    public function getByChildId(int $id): array
    {
        return $this->repository->byChild($id);
    }
    public function getScheduleForChild(int $id): array
    {
        return $this->repository->scheduleForChild($id);
    }
    public function findRecord(int $childId, int $id): ?array
    {
        return $this->repository->findRecord($childId, $id);
    }
    public function getDueChildren(): array
    {
        return $this->repository->dueChildren();
    }
    public function getAlerts(): array
    {
        return $this->repository->alerts();
    }
    public function getStatistics(): array
    {
        return $this->repository->statistics();
    }
    public function formOptions(): array
    {
        return ['schedules' => $this->repository->scheduleOptions(), 'staff' => $this->repository->staffOptions()];
    }

    public function create(int $childId, array $data): ?int
    {
        if (!$this->validate($data)) return null;
        return $this->repository->create($childId, $data);
    }

    public function update(int $childId, int $recordId, array $data): bool
    {
        if ($this->repository->findRecord($childId, $recordId) === null || !$this->validate($data)) return false;
        return $this->repository->update($childId, $recordId, $data);
    }

    private function validate(array $data): bool
    {
        $errors = [];
        if ((int) ($data['schedule_id'] ?? 0) < 1) $errors['schedule_id'] = 'Select a vaccine and dose.';
        if ((int) ($data['administered_by'] ?? 0) < 1) $errors['administered_by'] = 'Select the staff member who administered the vaccine.';
        if (empty($data['vaccination_date'])) $errors['vaccination_date'] = 'Vaccination date is required.';
        $statuses = ['Completed', 'Delayed', 'Missed', 'Contraindicated'];
        if (!in_array($data['vaccination_status'] ?? '', $statuses, true)) $errors['vaccination_status'] = 'Select a valid status.';
        if ($errors !== []) {
            $_SESSION['errors'] = $errors;
            $_SESSION['vaccinationData'] = $data;
            return false;
        }
        return true;
    }
}
