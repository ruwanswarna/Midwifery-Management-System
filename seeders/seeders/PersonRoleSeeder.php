<?php

require_once 'CsvSeeder.php';

class PersonRoleSeeder extends CsvSeeder
{
    public function run(): void
    {
        $this->seed('person_role', __DIR__ . '/../csv/person_role.csv');
    }
}
