<?php

declare(strict_types=1);
class FieldVisitService
{
    private FieldVisitRepository $repository;
    public function __construct()
    {
        $this->repository = new FieldVisitRepository();
    }
    public function getAll(): array
    {
        return $this->repository->getAll();
    }
    public function findById(int $id): ?array
    {
        return $this->repository->findById($id);
    }
    public function getByFamily(int $id): array
    {
        return $this->repository->byFamily($id);
    }
    public function options(): array
    {
        return ['families' => $this->repository->families(), 'staff' => $this->repository->staff(), 'people' => $this->repository->people()];
    }
    public function create(array $d): ?int
    {
        if (!$this->valid($d)) return null;
        return $this->repository->create($d);
    }
    public function update(int $id, array $d): bool
    {
        if (!$this->repository->findById($id) || !$this->valid($d)) return false;
        $this->repository->update($id, $d);
        return true;
    }
    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
    private function valid(array $d): bool
    {
        $e = [];
        foreach (['family_id', 'staff_id', 'visit_date', 'visit_type'] as $f) if (trim((string)($d[$f] ?? '')) === '') $e[$f] = 'This field is required.';
        if (isset($d['follow_up_required']) && empty($d['follow_up_date'])) $e['follow_up_date'] = 'Enter the follow-up date.';
        if ($e) {
            $_SESSION['errors'] = $e;
            $_SESSION['visitData'] = $d;
            return false;
        }
        return true;
    }
}
