<?php

require_once 'CsvSeeder.php';

class ChildSeeder extends CsvSeeder
{
    public function run(): void
    {
        $this->seed('child', __DIR__ . '/../csv/child.csv');
    }
}
