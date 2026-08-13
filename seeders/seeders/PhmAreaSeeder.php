<?php

require_once 'CsvSeeder.php';

class PhmAreaSeeder extends CsvSeeder
{
    public function run(): void
    {
        $this->seed(
            'phm_area',
            __DIR__ . '/../csv/phm_area.csv'
        );
    }
}
