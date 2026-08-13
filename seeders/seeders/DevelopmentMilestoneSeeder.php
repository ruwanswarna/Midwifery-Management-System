<?php

require_once 'CsvSeeder.php';

class DevelopmentMilestoneSeeder extends CsvSeeder
{
    public function run(): void
    {
        $this->seed('development_milestone', __DIR__ . '/../csv/development_milestone.csv');
    }
}