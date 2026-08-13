<?php

declare(strict_types=1);

class MotherService
{
    private MotherRepository $repository;
    public function __construct() { $this->repository = new MotherRepository(); }

    public function getAll(string $search = ''): array { return $this->repository->search(trim($search)); }
    public function findById(int $id): ?array { return $this->repository->findById($id); }
    public function getStatistics(): array { return $this->repository->statistics(); }
    public function getEligibleWomen(): array { return $this->repository->eligibleWomen(); }
    public function getPregnanciesByMother(int $id): array { return $this->repository->pregnancies($id); }
    public function getClinicVisitsByMother(int $id): array { return $this->repository->clinicVisits($id); }
    public function getFieldVisitsByMother(int $id): array { return $this->repository->fieldVisits($id); }
    public function getSupplementsByMother(int $id): array { return $this->repository->supplements($id); }

    public function create(array $data): bool
    {
        $personId = (int) ($data['person_id'] ?? 0);
        if ($personId < 1) {
            $_SESSION['errors'] = ['person_id' => 'Select an existing female family member.'];
            $_SESSION['motherData'] = $data;
            return false;
        }
        return $this->repository->markAsMother($personId);
    }

    public function update(int $id, array $data): bool
    {
        if ($this->repository->findById($id) === null || !$this->validate($data)) return false;
        try {
            return $this->repository->update($id, $data);
        } catch (PDOException $exception) {
            if ((int) ($exception->errorInfo[1] ?? 0) === 1062) {
                $_SESSION['errors'] = ['nic' => 'This NIC is already registered to another person.'];
                $_SESSION['motherData'] = $data;
                return false;
            }
            throw $exception;
        }
    }

    public function delete(int $id): bool { return false; }

    private function validate(array $data): bool
    {
        $errors = [];
        if (trim((string) ($data['first_name'] ?? '')) === '') $errors['first_name'] = 'First name is required.';
        if (trim((string) ($data['last_name'] ?? '')) === '') $errors['last_name'] = 'Last name is required.';
        if (empty($data['date_of_birth'])) $errors['date_of_birth'] = 'Date of birth is required.';
        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Enter a valid email address.';
        if ($errors !== []) {
            $_SESSION['errors'] = $errors;
            $_SESSION['motherData'] = $data;
            return false;
        }
        return true;
    }
}
