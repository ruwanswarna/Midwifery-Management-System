<?php

declare(strict_types=1);

class ClinicService
{
    private ClinicRepository $repository;

    public function __construct()
    {
        $this->repository = new ClinicRepository();
    }
    public function getAll(): array
    {
        return $this->repository->getAll();
    }
    public function findById(int $id): ?array
    {
        return $this->repository->findById($id);
    }
    public function getFormOptions(): array
    {
        return ['mohAreas' => $this->repository->getMohAreas(), 'staff' => $this->repository->getActiveStaff()];
    }
    public function create(array $data): ?int
    {
        if (!$this->validate($data)) return null;
        return $this->repository->create($data);
    }
    public function update(int $id, array $data): bool
    {
        if (!$this->repository->findById($id) || !$this->validate($data)) return false;
        $this->repository->update($id, $data);
        return true;
    }
    public function delete(int $id): bool
    {
        if (!$this->repository->findById($id)) return false;
        $this->repository->delete($id);
        return true;
    }
    private function validate(array $data): bool
    {
        $errors = [];
        foreach (['moh_area_id', 'conducted_by', 'session_type', 'clinic_date', 'location'] as $field) {
            if (trim((string) ($data[$field] ?? '')) === '') $errors[$field] = 'This field is required.';
        }
        if (!empty($data['start_time']) && !empty($data['end_time']) && $data['start_time'] >= $data['end_time']) {
            $errors['end_time'] = 'End time must be later than start time.';
        }
        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['clinicData'] = $data;
            return false;
        }
        return true;
    }
}
