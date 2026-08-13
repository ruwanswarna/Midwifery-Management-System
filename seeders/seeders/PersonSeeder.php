<?php

require_once 'CsvSeeder.php';

class PersonSeeder extends CsvSeeder
{
    public function run(): void
    {
        $this->seed(
            'person',
            __DIR__ . '/../csv/person.csv'
        );
    }
}
