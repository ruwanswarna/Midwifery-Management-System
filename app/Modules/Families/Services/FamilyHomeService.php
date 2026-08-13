<?php

declare(strict_types=1);
class FamilyHomeService
{
    private FamilyHomeRepository $repository;
    public function __construct()
    {
        $this->repository = new FamilyHomeRepository();
    }
    public function getById(int $id): ?array
    {
        return $this->repository->findByFamily($id);
    }
    public function update(int $id, array $data): bool
    {
        if (trim((string)($data['address'] ?? '')) === '') {
            $_SESSION['errors'] = ['address' => 'Address is required.'];
            $_SESSION['homeData'] = $data;
            return false;
        }
        return $this->repository->update($id, $data);
    }
}
