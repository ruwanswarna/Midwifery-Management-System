<?php

require_once 'CsvSeeder.php';

class SupplementMasterSeeder extends CsvSeeder
{
    public function run(): void
    {
        $this->seed('supplement_master', __DIR__ . '/../csv/supplement_master.csv');
    }
}