<?php

require_once 'CsvSeeder.php';

class VaccineMasterSeeder extends CsvSeeder
{
    public function run(): void
    {
        $this->seed('vaccine_master', __DIR__ . '/../csv/vaccine_master.csv');
    }
}