<?php

declare(strict_types=1);

class ChildService
{
    private ChildRepository $repository;

    public function __construct()
    {
        $this->repository = new ChildRepository();
    }

    public function overview(): array
    {
        return [
            'children' => $this->repository->findRecent(),
            'statistics' => $this->repository->statistics(),
        ];
    }

    public function getAll(string $search = ''): array
    {
        return $this->repository->search(trim($search));
    }

    public function findById(int $id): ?array
    {
        return $this->repository->findById($id);
    }

    public function getByFamily(int $familyId): array
    {
        return $this->repository->byFamily($familyId);
    }

    public function formOptions(): array
    {
        return [
            'people' => $this->repository->findEligiblePeople(),
            'birthOutcomes' => $this->repository->findAvailableBirthOutcomes(),
        ];
    }

    public function create(array $data): bool
    {
        if (!$this->validate($data, true)) {
            return false;
        }

        try {
            return $this->repository->create($data);
        } catch (PDOException $exception) {
            $code = (int) ($exception->errorInfo[1] ?? 0);
            if ($code === 1062) {
                $_SESSION['errors'] = ['person_id' => 'This person already has a child health record.'];
                $_SESSION['childData'] = $data;
                return false;
            }
            throw $exception;
        }
    }

    public function update(int $id, array $data): bool
    {
        if ($this->repository->findById($id) === null || !$this->validate($data, false)) {
            return false;
        }
        return $this->repository->update($id, $data);
    }

    public function archive(int $id): bool
    {
        if ($this->repository->findById($id) === null) {
            $_SESSION['errors'] = ['general' => 'Child health record not found.'];
            return false;
        }

        $_SESSION['errors'] = [
            'general' => 'Archiving is unavailable until an archive/status field is added to the child table.',
        ];
        return false;
    }

    private function validate(array $data, bool $creating): bool
    {
        $errors = [];
        if ($creating && (int) ($data['person_id'] ?? 0) < 1) {
            $errors['person_id'] = 'Select an existing child from a registered family.';
        }
        if ((int) ($data['birth_outcome_id'] ?? 0) < 1) {
            $errors['birth_outcome_id'] = 'Select the corresponding live birth outcome.';
        }
        $ranges = [
            'birth_weight_kg' => [0.30, 8.00, 'Birth weight'],
            'birth_length_cm' => [20, 70, 'Birth length'],
            'head_circumference_cm' => [20, 60, 'Head circumference'],
        ];
        foreach ($ranges as $field => [$min, $max, $label]) {
            $value = trim((string) ($data[$field] ?? ''));
            if ($value !== '' && (!is_numeric($value) || (float) $value < $min || (float) $value > $max)) {
                $errors[$field] = "{$label} must be between {$min} and {$max}.";
            }
        }
        $feeding = trim((string) ($data['breastfeeding_status'] ?? ''));
        if ($feeding !== '' && !in_array($feeding, ['Exclusive', 'Mixed', 'Formula', 'Stopped'], true)) {
            $errors['breastfeeding_status'] = 'Select a valid breastfeeding status.';
        }
        if ($errors !== []) {
            $_SESSION['errors'] = $errors;
            $_SESSION['childData'] = $data;
            return false;
        }
        return true;
    }
}
