<?php

declare(strict_types=1);

class SupplimentDistService
{
    private SupplimentDistRepository $repository;
    public function __construct()
    {
        $this->repository = new SupplimentDistRepository();
    }

    public function getAll(): array
    {
        return $this->repository->recent();
    }
    public function getRecentChildDistributions(int $limit = 100): array
    {
        return $this->repository->recent('Child', $limit);
    }
    public function getRecentMaternalDistributions(int $limit = 100): array
    {
        return array_values(array_filter($this->repository->recent(null, $limit), static fn(array $row): bool => in_array($row['recipient_type'], ['Pregnant Mother', 'Lactating Mother'], true)));
    }
    public function getByPerson(int $id): array
    {
        return $this->repository->byPerson($id);
    }
    public function getDueRecipients(?string $type = null): array
    {
        return $this->repository->due($type);
    }
    public function getStatistics(): array
    {
        return $this->repository->statistics();
    }
    public function findRecord(int $personId, int $id): ?array
    {
        return $this->repository->findRecord($personId, $id);
    }
    public function findById(int $id): ?array
    {
        return $this->repository->findById($id);
    }
    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
    public function formOptions(string $type): array
    {
        return ['supplements' => $this->repository->supplementOptions($type), 'staff' => $this->repository->staffOptions()];
    }

    public function create(int $personId, string $recipientType, array $data): ?int
    {
        if (!$this->validate($data)) return null;
        return $this->repository->create($personId, $recipientType, $data);
    }

    public function update(int $personId, int $distributionId, array $data): bool
    {
        if ($this->repository->findRecord($personId, $distributionId) === null || !$this->validate($data)) return false;
        return $this->repository->update($personId, $distributionId, $data);
    }

    private function validate(array $data): bool
    {
        $errors = [];
        if ((int) ($data['supplement_id'] ?? 0) < 1) $errors['supplement_id'] = 'Select a supplement.';
        if ((int) ($data['distributed_by'] ?? 0) < 1) $errors['distributed_by'] = 'Select the staff member recording the distribution.';
        if (empty($data['distribution_date'])) $errors['distribution_date'] = 'Distribution date is required.';
        if (!is_numeric($data['quantity'] ?? null) || (float) ($data['quantity'] ?? 0) <= 0) $errors['quantity'] = 'Quantity must be greater than zero.';
        if (!empty($data['expiry_date']) && !empty($data['distribution_date']) && $data['expiry_date'] < $data['distribution_date']) $errors['expiry_date'] = 'Expiry date cannot precede distribution date.';
        if ($errors !== []) {
            $_SESSION['errors'] = $errors;
            $_SESSION['supplementData'] = $data;
            return false;
        }
        return true;
    }
}
