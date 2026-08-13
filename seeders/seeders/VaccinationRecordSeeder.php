<?php

require_once 'CsvSeeder.php';

class VaccinationRecordSeeder extends CsvSeeder
{
    public function run(): void
    {
        $this->seed('vaccination_record', __DIR__ . '/../csv/vaccination_record.csv');
    }
}
