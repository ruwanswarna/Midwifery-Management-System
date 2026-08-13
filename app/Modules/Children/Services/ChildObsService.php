<?php

declare(strict_types=1);

class ChildObsService
{
    private ChildObservationRepository $repository;
    public function __construct()
    {
        $this->repository = new ChildObservationRepository();
    }

    public function getAll(): array
    {
        return $this->repository->recent();
    }
    public function getMilestones(): array
    {
        return $this->repository->findMilestones();
    }
    public function getObservationsByChildId(int $id): array
    {
        return $this->repository->byChild($id);
    }
    public function getAlerts(): array
    {
        return $this->repository->alerts();
    }
    public function findRecord(int $childId, int $id): ?array
    {
        return $this->repository->findRecord($childId, $id);
    }
    public function formOptions(): array
    {
        return ['milestones' => $this->repository->milestoneOptions(), 'staff' => $this->repository->staffOptions()];
    }

    public function addObservation(int $childId, array $data): ?int
    {
        if (!$this->validate($data)) return null;
        return $this->repository->create($childId, $data);
    }

    public function updateObservation(int $childId, int $observationId, array $data): bool
    {
        if ($this->repository->findRecord($childId, $observationId) === null || !$this->validate($data)) return false;
        return $this->repository->update($childId, $observationId, $data);
    }

    private function validate(array $data): bool
    {
        $errors = [];
        if ((int) ($data['milestone_id'] ?? 0) < 1) $errors['milestone_id'] = 'Select a developmental milestone.';
        if ((int) ($data['observed_by'] ?? 0) < 1) $errors['observed_by'] = 'Select the observing staff member.';
        if (empty($data['observation_date'])) $errors['observation_date'] = 'Observation date is required.';
        if (!in_array($data['observation_status'] ?? '', ['Achieved', 'Delayed', 'Not Achieved'], true)) $errors['observation_status'] = 'Select a valid observation status.';
        if (isset($data['follow_up_required']) && empty($data['follow_up_date'])) $errors['follow_up_date'] = 'Enter the planned follow-up date.';
        if ($errors !== []) {
            $_SESSION['errors'] = $errors;
            $_SESSION['observationData'] = $data;
            return false;
        }
        return true;
    }
}
