<?php

require_once 'CsvSeeder.php';

class ChildDevelopmentObservationSeeder extends CsvSeeder
{
    public function run(): void
    {
        $this->seed(
            'child_development_observation',
            __DIR__ . '/../csv/child_development_observation.csv'
        );
    }
}
