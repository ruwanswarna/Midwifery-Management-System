<?php
// get(endpoint_url, controller, controller_action_method)


/** @var Router $router */

// NOTE Children module
// Children overview
$router->get(
    '/children',
    [ChildController::class, 'index'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

// Children registry
$router->get(
    '/children/registry',
    [ChildController::class, 'registry'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

// Register child form
$router->get(
    '/children/create',
    [ChildController::class, 'create'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

// Register child form submission
$router->post(
    '/children/create',
    [ChildController::class, 'store'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

// System-wide growth monitoring
$router->get(
    '/children/growth',
    [GrowthController::class, 'indexGrowthSummary'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

// System-wide age observations
$router->get(
    '/children/observations',
    [ChildObsController::class, 'index'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

// System-wide child vaccinations
$router->get(
    '/children/vaccinations',
    [ImmunizationController::class, 'indexVaccinationSummary'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

// System-wide child supplementation
$router->get(
    '/children/supplements',
    [SupplimentDistController::class, 'childrenSupplementIndex'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

// Child reports
$router->get(
    '/children/reports',
    [ChildController::class, 'reports'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);


// Selected child: growth


$router->get(
    '/children/{id}/growth',
    [GrowthController::class, 'show'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

$router->get(
    '/children/{id}/growth/create',
    [GrowthController::class, 'create'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

$router->post(
    '/children/{id}/growth/create',
    [GrowthController::class, 'store'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

$router->get(
    '/children/{id}/growth/{measurementId}/edit',
    [GrowthController::class, 'edit'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

$router->post(
    '/children/{id}/growth/{measurementId}/update',
    [GrowthController::class, 'update'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);


// Selected child: age observations

$router->get(
    '/children/{id}/observations',
    [ChildObsController::class, 'show'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

$router->get(
    '/children/{id}/observations/create',
    [ChildObsController::class, 'create'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

$router->post(
    '/children/{id}/observations/create',
    [ChildObsController::class, 'store'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

$router->get(
    '/children/{id}/observations/{observationId}/edit',
    [ChildObsController::class, 'edit'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

$router->post(
    '/children/{id}/observations/{observationId}/update',
    [ChildObsController::class, 'update'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);


// Selected child: vaccinations


$router->get(
    '/children/{id}/vaccinations',
    [ImmunizationController::class, 'show'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

$router->get(
    '/children/{id}/vaccinations/create',
    [ImmunizationController::class, 'create'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

$router->post(
    '/children/{id}/vaccinations/create',
    [ImmunizationController::class, 'store'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

$router->get(
    '/children/{id}/vaccinations/{recordId}/edit',
    [ImmunizationController::class, 'edit'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

$router->post(
    '/children/{id}/vaccinations/{recordId}/update',
    [ImmunizationController::class, 'update'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);


// Selected child: supplements


$router->get(
    '/children/{id}/supplements',
    [SupplimentDistController::class, 'showChildSuppliments'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

$router->get(
    '/children/{id}/supplements/create',
    [SupplimentDistController::class, 'create'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

$router->post(
    '/children/{id}/supplements/create',
    [SupplimentDistController::class, 'store'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

$router->get(
    '/children/{id}/supplements/{distributionId}/edit',
    [SupplimentDistController::class, 'edit'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

$router->post(
    '/children/{id}/supplements/{distributionId}/update',
    [SupplimentDistController::class, 'update'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);


// Selected child record


$router->get(
    '/children/{id}',
    [ChildController::class, 'show'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

$router->get(
    '/children/{id}/edit',
    [ChildController::class, 'edit'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

$router->post(
    '/children/{id}/update',
    [ChildController::class, 'update'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

$router->post(
    '/children/{id}/archive',
    [ChildController::class, 'archive'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);
