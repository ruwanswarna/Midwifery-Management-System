<?php

require_once 'CsvSeeder.php';

class StaffSeeder extends CsvSeeder
{
    public function run(): void
    {
        $this->seed(
            'staff',
            __DIR__ . '/../csv/staff.csv'
        );
    }
}