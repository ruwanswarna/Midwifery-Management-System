<?php

require_once 'CsvSeeder.php';

class FamilySeeder extends CsvSeeder
{
    public function run(): void
    {
        $this->seed(
            'family',
            __DIR__ . '/../csv/family.csv'
        );
    }
}