<?php

require_once 'CsvSeeder.php';

class VaccineScheduleSeeder extends CsvSeeder
{
    public function run(): void
    {
        $this->seed('vaccine_schedule', __DIR__ . '/../csv/vaccine_schedule.csv');
    }
}