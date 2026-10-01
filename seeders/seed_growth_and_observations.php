<?php

require_once 'seeders/GrowthMeasurementSeeder.php';
require_once 'seeders/ChildDevelopmentObservationSeeder.php';

$seeders = [
    new GrowthMeasurementSeeder(),
    new ChildDevelopmentObservationSeeder(),
];

foreach ($seeders as $seeder) {
    echo 'Running ' . get_class($seeder) . '...' . PHP_EOL;
    $seeder->run();
}

echo PHP_EOL . 'Growth and development observation seeding completed successfully.' . PHP_EOL;
