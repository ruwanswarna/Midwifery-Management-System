<?php
// get(endpoint_url, controller, controller_action_method)

/** @var Router $router */

// NOTE Dashboard
$router->get(
	'/',
	[DashboardController::class, 'index'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

$router->get(
	'/dashboard',
	[DashboardController::class, 'index'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);
