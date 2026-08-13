<?php

declare(strict_types=1);

class PregnancyService
{
    private PregnancyRepository $repository;
    public function __construct() { $this->repository = new PregnancyRepository(); }

    public function getAll(string $search = '', ?string $status = null): array { return $this->repository->search(trim($search), $status); }
    public function findById(int $id): ?array { return $this->repository->findById($id); }
    public function findMotherById(int $id): ?array { return (new MotherRepository())->findById($id); }
    public function getMothers(): array { return $this->repository->mothers(); }
    public function getHighRiskPregnancies(): array { return $this->repository->highRisk(); }
    public function getExpectedDeliveries(): array { return $this->repository->expectedDeliveries(); }
    public function getVisits(): array { return $this->repository->visits(); }
    public function getBirthOutcomes(): array { return $this->repository->birthOutcomes(); }
    public function getStatistics(): array { return $this->repository->statistics(); }
    public function getPregnanciesByMother(int $id): array { return array_values(array_filter($this->repository->search('', null, 500), static fn (array $p): bool => (int) $p['mother_id'] === $id)); }

    public function create(array $data): bool
    {
        if (!$this->validate($data)) return false;
        $this->repository->create($data);
        return true;
    }

    public function update(int $id, array $data): bool
    {
        if ($this->repository->findById($id) === null || !$this->validate($data)) return false;
        return $this->repository->update($id, $data);
    }

    public function delete(int $id): bool { return $this->repository->delete($id); }

    public function createBirthOutcome(int $pregnancyId, array $data): bool
    {
        $errors = [];
        if (!in_array($data['outcome_type'] ?? '', ['Live Birth', 'Live Birth - Expired', 'Still Birth', 'Miscarriage', 'Abortion'], true)) $errors['outcome_type'] = 'Select a valid outcome.';
        if (empty($data['delivery_date'])) $errors['delivery_date'] = 'Delivery or outcome date is required.';
        $weeks = trim((string) ($data['gestational_age_weeks'] ?? ''));
        if ($weeks !== '' && (!ctype_digit($weeks) || (int) $weeks < 20 || (int) $weeks > 45)) $errors['gestational_age_weeks'] = 'Gestational age must be between 20 and 45 weeks.';
        if ($errors !== []) { $_SESSION['errors'] = $errors; $_SESSION['outcomeData'] = $data; return false; }
        $this->repository->createBirthOutcome($pregnancyId, $data);
        return true;
    }

    public function calculateExpectedDeliveryDate(string $lastMenstrualPeriod, int $cycleLength = 28): string
    {
        $estimatedDate = (new DateTimeImmutable($lastMenstrualPeriod))->modify('+280 days');
        $adjustment = $cycleLength - 28;
        if ($adjustment !== 0) $estimatedDate = $estimatedDate->modify(($adjustment > 0 ? '+' : '') . $adjustment . ' days');
        return $estimatedDate->format('Y-m-d');
    }

    private function validate(array $data): bool
    {
        $errors = [];
        if ((int) ($data['mother_id'] ?? 0) < 1) $errors['mother_id'] = 'Select a registered mother.';
        foreach (['registered_date' => 'Registration date is required.', 'last_menstrual_period' => 'Last menstrual period is required.', 'expected_delivery_date' => 'Expected delivery date is required.'] as $field => $message) if (empty($data[$field])) $errors[$field] = $message;
        if (!empty($data['last_menstrual_period']) && !empty($data['expected_delivery_date']) && $data['expected_delivery_date'] <= $data['last_menstrual_period']) $errors['expected_delivery_date'] = 'Expected delivery must be after the last menstrual period.';
        $gravida = (int) ($data['gravida'] ?? 0); $para = (int) ($data['para'] ?? 0);
        if ($gravida < $para) $errors['gravida'] = 'Gravida cannot be lower than para.';
        if (!empty($data['bmi_at_booking']) && ((float) $data['bmi_at_booking'] < 10 || (float) $data['bmi_at_booking'] > 60)) $errors['bmi_at_booking'] = 'BMI must be between 10 and 60.';
        if (!empty($data['hemoglobin_level']) && ((float) $data['hemoglobin_level'] < 1 || (float) $data['hemoglobin_level'] > 25)) $errors['hemoglobin_level'] = 'Hemoglobin must be between 1 and 25.';
        if ($errors !== []) { $_SESSION['errors'] = $errors; $_SESSION['pregnancyData'] = $data; return false; }
        return true;
    }
}
