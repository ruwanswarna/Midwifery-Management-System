<?php

declare(strict_types=1);
class GuardianshipService
{
    private GuardianshipRepository $repository;
    public function __construct()
    {
        $this->repository = new GuardianshipRepository();
    }
    public function getFamilyById(int $id): ?array
    {
        return $this->repository->family($id);
    }
    public function getGuardians(int $id): array
    {
        return $this->repository->guardians($id);
    }
    public function getCandidates(int $id): array
    {
        return $this->repository->candidates($id);
    }
    public function getChildren(int $id): array
    {
        return $this->repository->children($id);
    }
    public function designate(int $familyId, array $data): bool
    {
        $personId = (int)($data['person_id'] ?? 0);
        if ($personId < 1) {
            $_SESSION['errors'] = ['Select an adult family member.'];
            return false;
        }
        return $this->repository->designate($familyId, $personId);
    }
    public function end(int $familyId, int $personId): bool
    {
        return $this->repository->end($familyId, $personId);
    }
}
