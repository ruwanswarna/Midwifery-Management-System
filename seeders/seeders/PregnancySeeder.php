<?php

require_once 'CsvSeeder.php';

class PregnancySeeder extends CsvSeeder
{
    public function run(): void
    {
        $this->seed(
            'pregnancy',
            __DIR__ . '/../csv/pregnancy.csv'
        );
    }
}
