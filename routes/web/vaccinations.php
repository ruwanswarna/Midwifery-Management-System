<?php

declare(strict_types=1);

/** @var Router $router */


// NOTE Vaccinations module routes - but logically a child module, since it is a sub-module of the Children module
$router->get(
	'/children/vaccinations',
	[ImmunizationController::class, 'indexVaccinationSummary'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);
// Complete list of children with overdue vaccinations
$router->get(
	'/children/vaccinations/overdue',
	[ImmunizationController::class, 'childrenDueVaccinations'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// Children requiring vaccination-related attention
$router->get(
	'/children/vaccinations/alerts',
	[ImmunizationController::class, 'childrenWithAlerts'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]

);
