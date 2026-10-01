<?php

require_once 'DistrictSeeder.php';
require_once 'MohAreaSeeder.php';
require_once 'PhmAreaSeeder.php';

require_once 'PersonRoleSeeder.php';
// require_once 'RelationshipSeeder.php';
// require_once 'OccupationSeeder.php';

require_once 'StaffSeeder.php';
require_once 'FamilySeeder.php';
require_once 'PersonSeeder.php';

require_once 'PregnancySeeder.php';
require_once 'BirthOutcomeSeeder.php';
require_once 'ChildSeeder.php';
require_once 'DevelopmentMilestoneSeeder.php';
require_once 'GrowthMeasurementSeeder.php';
require_once 'ChildDevelopmentObservationSeeder.php';

require_once 'VaccinationRecordSeeder.php';

$seeders = [

    new DistrictSeeder(),
    new MohAreaSeeder(),
    new PhmAreaSeeder(),

    new PersonRoleSeeder(),
    new StaffSeeder(),

    new FamilySeeder(),
    new PersonSeeder(),

    new PregnancySeeder(),
    new BirthOutcomeSeeder(),
    new ChildSeeder(),
    new DevelopmentMilestoneSeeder(),
    new GrowthMeasurementSeeder(),
    new ChildDevelopmentObservationSeeder(),

    new VaccinationRecordSeeder()

];

foreach ($seeders as $seeder) {

    echo "Running "
        . get_class($seeder)
        . "..." . PHP_EOL;

    $seeder->run();
}

echo PHP_EOL;
echo "Database seeding completed successfully.";
