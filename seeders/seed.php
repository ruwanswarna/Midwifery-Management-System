<?php

declare(strict_types=1);

require_once __DIR__ . '/seeders/DatabaseSeeder.php';

$seeder = new DatabaseSeeder();
$targets = array_slice($argv, 1);

if ($targets === ['--list']) {
	echo implode(PHP_EOL, $seeder->available()) . PHP_EOL;
	exit(0);
}

if ($targets === [] || $targets === ['all']) {
	$seeder->runAll();
	exit(0);
}

$seeder->run($targets);
