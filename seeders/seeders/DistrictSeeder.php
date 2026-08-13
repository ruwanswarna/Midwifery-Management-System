<?php

require_once 'CsvSeeder.php';

class DistrictSeeder extends CsvSeeder
{
    public function run(): void
    {
        $this->seed(
            'district',
            __DIR__ . '/../csv/district.csv'
        );
    }
}