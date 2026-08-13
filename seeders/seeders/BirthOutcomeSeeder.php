<?php

declare(strict_types=1);

require_once __DIR__ . '/CsvSeeder.php';

class BirthOutcomeSeeder extends CsvSeeder
{
    public function run(): void
    {
        $this->seed('birth_outcome', __DIR__ . '/../csv/birth_outcome.csv');
    }
}
