<?php

require_once 'CsvSeeder.php';

class MohAreaSeeder extends CsvSeeder
{
    public function run(): void
    {
        $this->seed(
            'moh_area',
            __DIR__ . '/../csv/moh_area.csv'
        );
    }
}