<?php

require_once 'CsvSeeder.php';

class GrowthMeasurementSeeder extends CsvSeeder
{
    public function run(): void
    {
        $this->seed(
            'growth_measurement',
            __DIR__ . '/../csv/growth_measurement.csv'
        );
    }
}
