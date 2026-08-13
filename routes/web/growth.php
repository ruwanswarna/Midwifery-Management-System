
<?php
// get(endpoint_url, controller, controller_action_method)

/// NOTE Growth Monitoring module routes - but logically a child module, since it is a sub-module of the Children module
/** @var Router $router */
// Children due or overdue for growth monitoring

$router->get(
	'/children/growth',
	[GrowthController::class, 'indexGrowthSummary'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

$router->get(
	'/children/growth/overdue',
	[GrowthController::class, 'childrenDueMeasurement'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// Children with growth alerts
$router->get(
	'/children/growth/alerts',
	[GrowthController::class, 'childrenWithAlerts'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);
