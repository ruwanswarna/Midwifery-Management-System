<?php

declare(strict_types=1);

/** @var Router $router */

/*
|--------------------------------------------------------------------------
| Supplements operational module
|--------------------------------------------------------------------------
*/

// Overview across all recipients
$router->get(
	'/supplements',
	[SupplimentDistController::class, 'index'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// Child-focused overview
$router->get(
	'/supplements/children',
	[SupplimentDistController::class, 'childrenSupplementIndex'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// Mother-focused overview
$router->get(
	'/supplements/mothers',
	[SupplimentDistController::class, 'mothersSupplementIndex'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);


// Due and overdue supplementation
$router->get(
	'/supplements/due',
	[SupplimentDistController::class, 'dueAndOverdue'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// Reports
$router->get(
	'/supplements/reports',
	[SupplimentDistController::class, 'reports'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// suppliments for a specific child
// Child supplement history
$router->get(
	'/children/{id}/supplements',
	[SupplimentDistController::class, 'showChildSuppliments'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// Record distribution form
$router->get(
	'/children/{id}/supplements/create',
	[SupplimentDistController::class, 'create'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// Record distribution submission
$router->post(
	'/children/{id}/supplements/create',
	[SupplimentDistController::class, 'store'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// suppliments for a specific mother
// Mother supplement history
$router->get(
	'/mothers/{id}/supplements',
	[SupplimentDistController::class, 'showMotherSuppliments'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// Record distribution form
$router->get(
	'/mothers/{id}/supplements/create',
	[SupplimentDistController::class, 'create'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// Record distribution submission
$router->post(
	'/mothers/{id}/supplements/create',
	[SupplimentDistController::class, 'store'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

/*
|--------------------------------------------------------------------------
| Existing supplement distribution
|--------------------------------------------------------------------------
*/

// Correction form
$router->get(
	'/supplements/distributions/{id}/edit',
	[SupplementDistributionController::class, 'edit'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// Correction submission
$router->post(
	'/supplements/distributions/{id}/update',
	[SupplementDistributionController::class, 'update'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// Void an incorrect record
$router->post(
	'/supplements/distributions/{id}/void',
	[SupplementDistributionController::class, 'voidRecord'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);
	
