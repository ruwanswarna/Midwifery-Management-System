<?php
// get(endpoint_url, controller, controller_action_method)

/** @var Router $router */

// NOTE Users
$router->get(
	'/users',
	[UserController::class, 'index'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

$router->get(
	'/users/create',
	[UserController::class, 'create'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

$router->post(
	'/users/create',
	[UserController::class, 'store'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

$router->get(
	'/users/{id}',
	[UserController::class, 'show'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

$router->get(
	'/users/{id}/edit',
	[UserController::class, 'edit'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

$router->post(
	'/users/{id}/edit',
	[UserController::class, 'update'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

$router->post(
	'/users/{id}/delete',
	[UserController::class, 'delete'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);
