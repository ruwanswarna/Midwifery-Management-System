<?php

declare(strict_types=1);

require_once __DIR__ . '/DistrictSeeder.php';
require_once __DIR__ . '/MohAreaSeeder.php';
require_once __DIR__ . '/PhmAreaSeeder.php';
require_once __DIR__ . '/PersonRoleSeeder.php';
require_once __DIR__ . '/StaffSeeder.php';
require_once __DIR__ . '/FamilySeeder.php';
require_once __DIR__ . '/PersonSeeder.php';
require_once __DIR__ . '/PregnancySeeder.php';
require_once __DIR__ . '/BirthOutcomeSeeder.php';
require_once __DIR__ . '/ChildSeeder.php';
require_once __DIR__ . '/VaccineMasterSeeder.php';
require_once __DIR__ . '/VaccineScheduleSeeder.php';
require_once __DIR__ . '/VaccinationRecordSeeder.php';
require_once __DIR__ . '/SupplementMasterSeeder.php';
require_once __DIR__ . '/DevelopmentMilestoneSeeder.php';

final class DatabaseSeeder
{
    /** @var array<string, class-string<CsvSeeder>> */
    private array $seeders = [
        'district' => DistrictSeeder::class,
        'moh_area' => MohAreaSeeder::class,
        'phm_area' => PhmAreaSeeder::class,
        'person_role' => PersonRoleSeeder::class,
        'staff' => StaffSeeder::class,
        'family' => FamilySeeder::class,
        'person' => PersonSeeder::class,
        'pregnancy' => PregnancySeeder::class,
        'birth_outcome' => BirthOutcomeSeeder::class,
        'child' => ChildSeeder::class,
        'vaccine_master' => VaccineMasterSeeder::class,
        'vaccine_schedule' => VaccineScheduleSeeder::class,
        'vaccination_record' => VaccinationRecordSeeder::class,
        'supplement_master' => SupplementMasterSeeder::class,
        'development_milestone' => DevelopmentMilestoneSeeder::class,
    ];

    /** @return list<string> */
    public function available(): array
    {
        return array_keys($this->seeders);
    }

    /** @param list<string> $targets */
    public function run(array $targets): void
    {
        foreach ($targets as $target) {
            if (!isset($this->seeders[$target])) {
                throw new InvalidArgumentException(
                    "Unknown seeder '{$target}'. Use: php seed.php --list"
                );
            }

            $class = $this->seeders[$target];
            echo "Running {$class}..." . PHP_EOL;
            (new $class())->run();
        }

        echo "Selected seeding completed successfully." . PHP_EOL;
    }

    public function runAll(): void
    {
        $this->run($this->available());
    }
}
