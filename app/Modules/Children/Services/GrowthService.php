<?php

declare(strict_types=1);


class GrowthService
{
    private GrowthRepository $growthRepository;
    private ChildRepository $childRepository;
    private AnthroApiClient $anthroApi;

    public function __construct()
    {
        $this->growthRepository = new GrowthRepository();
        $this->childRepository = new ChildRepository();
        $this->anthroApi = new AnthroApiClient('http://127.0.0.1:8000');
    }
    public function create(int $childId, array $data): ?int
    {
        // find whether this child exist
        $child = $this->childRepository->findById($childId);
        if ($child === null) {
            return null;
        }
        // validate form data
        if (!$this->validate($data)) return null;

        // prepare the data for api call
        $preparedData = $this->prepareMeasurementData($child, $data);

        // format anthro analyzer request data
        $anthroPostRecord = $this->createAnthroPostRecord($child, $preparedData);

        try {
            // api call to anthro analyzer
            $response = $this->anthroApi->calculateZScores(
                [$anthroPostRecord]
            );
            // extract data from  response body
            if ($response['ok'] === false) {
                $_SESSION['errors'] = [
                    'anthro' =>
                    'The growth assessment service is unavailable. '
                        . $response['error'],
                ];
                return null;
            }
            $result = $response['results'][0] ?? null;
            $measurements = $result['measurements'] ?? null;
            $interpretations = $result['interpretation'] ?? null;

            // apply the result to the prepared data for database insertion
            if ( $measurements['zwei'][0] !== 'NA') {
                $data['weight_for_age_z_score'] =
                    $measurements['zwei'][0] ?? null;
            } else {
                $data['weight_for_age_z_score'] = null;
            }
            if ($measurements['zlen'][0] !== 'NA') {
                $data['height_for_age_z_score'] =
                    $measurements['zlen'][0] ?? null;
            } else {
                $data['height_for_age_z_score'] = null;
            }
            if ( $measurements['zwfl'][0] !== 'NA') {
                $data['weight_for_height_z_score'] =
                    $measurements['zwfl'][0] ?? null;
            } else {
                $data['weight_for_height_z_score'] = null;
            }
        } catch (RuntimeException $exception) {
            $_SESSION['errors'] = [
                'anthro' =>
                'The growth assessment service is unavailable. '
                    . $exception->getMessage(),
            ];

            $_SESSION['growthData'] = $data;

            return null;
        }
        return $this->growthRepository->create(
            $childId,
            $data
        );
    }

    public function update(int $childId, int $measurementId, array $data): bool
    {
        if ($this->growthRepository->findRecord($childId, $measurementId) === null || !$this->validate($data)) return false;
        return $this->growthRepository->update($childId, $measurementId, $data);
    }

    private function validate(array $data): bool
    {
        $errors = [];
        foreach (
            [
                'measured_by' => 'Select the staff member who measured the child.',
                'measurement_date' => 'Measurement date is required.'
            ] as $field => $message
        ) {
            if (trim((string) ($data[$field] ?? '')) === '') $errors[$field] = $message;
        }
        if ((int) ($data['measured_by'] ?? 0) < 1) $errors['measured_by'] = 'Select a valid staff member.';

        foreach (['weight_kg', 'height_cm', 'head_circumference_cm', 'muac_cm', 'bmi'] as $field) {
            $value = trim((string) ($data[$field] ?? ''));
            if ($value !== '' && (!is_numeric($value) || (float) $value < 0)) $errors[$field] = 'Enter a valid value.';
        }
        $statuses = ['Normal', 'Underweight', 'Severely Underweight', 'Stunted', 'Severely Stunted', 'Wasted', 'Severely Wasted', 'Overweight'];

        if ($errors !== []) {
            $_SESSION['errors'] = $errors;
            $_SESSION['growthData'] = $data;
            return false;
        }
        return true;
    }

    public function getAll(): array
    {
        return $this->growthRepository->recent();
    }
    public function getByChildId(int $id): array
    {
        return $this->growthRepository->findByChildId($id);
    }
    public function findRecord(int $childId, int $id): ?array
    {
        return $this->growthRepository->findRecord($childId, $id);
    }
    public function getDueChildren(): array
    {
        return $this->growthRepository->dueChildren();
    }
    public function getActiveAlerts(): array
    {
        return $this->growthRepository->alerts();
    }
    public function getStatistics(): array
    {
        return $this->growthRepository->statistics();
    }
    public function getStaffOptions(): array
    {
        return $this->growthRepository->staffOptions();
    }

    private function prepareMeasurementData(array $child, array $data): array
    {

        $birthDate = new DateTimeImmutable(
            $child['date_of_birth']
        );

        $measurementDate = new DateTimeImmutable(
            $data['measurement_date']
        );

        $age = $birthDate->diff($measurementDate);

        $data['age_in_days'] = (int) $age->days;

        $data['age_in_months'] =
            ($age->y * 12) + $age->m;

        $weight = isset($data['weight_kg'])
            && is_numeric($data['weight_kg'])
            ? (float) $data['weight_kg']
            : null;

        $height = isset($data['height_cm'])
            && is_numeric($data['height_cm'])
            ? (float) $data['height_cm']
            : null;

        if (
            $weight !== null
            && $height !== null
            && $weight > 0
            && $height > 0
        ) {
            $heightMetres = $height / 100;

            $data['bmi'] = round(
                $weight / ($heightMetres ** 2),
                2
            );
        } else {
            $data['bmi'] = null;
        }
        // temporary defaults until anthro API is connected
        $data['weight_for_age_z_score'] = null;
        $data['height_for_age_z_score'] = null;
        $data['weight_for_height_z_score'] = null;
        $data['growth_status'] = null;

        return $data;
    }

    private function createAnthroPostRecord(array $child, array $data): array
    {
        $sex = match ($child['gender'] ?? null) {
            'Male' => 'M',
            'Female' => 'F',

            default => throw new DomainException(
                'A valid child gender is required.'
            ),
        };

        $record = [
            'measurement_position' =>
            $data['measurement_position']
                ?? ((int) $data['age_in_months'] < 24 ? 'L' : 'H'),
            'sex' => $sex,
            'age_days' => (int) $data['age_in_days'],
            'weight_kg' => $this->floatOrNull(
                $data['weight_kg'] ?? null
            ),
            'length_height_cm' => $this->floatOrNull(
                $data['height_cm'] ?? null
            ),
            'head_circumference_cm' => $this->floatOrNull(
                $data['head_circumference_cm'] ?? null
            ),
            'arm_circumference_cm' => $this->floatOrNull(
                $data['muac_cm'] ?? null
            ),

        ];


        // do not send null fields 
        return array_filter(
            $record,
            static fn(mixed $value): bool => $value !== null
        );
    }

    private function floatOrNull(mixed $value): ?float
    {
        return $value !== null
            && $value !== ''
            && is_numeric($value)
            ? (float) $value
            : null;
    }
}
