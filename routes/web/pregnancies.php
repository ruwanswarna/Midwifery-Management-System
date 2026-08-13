<?php
// get(endpoint_url, controller, controller_action_method)

/** @var Router $router */



// NOTE Pregnancies
// pregnancies overview page
$router->get(
    '/pregnancies',
    [PregnancyController::class, 'index'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

// pregnancies registry page
$router->get(
    '/pregnancies/registry',
    [PregnancyController::class, 'registry'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

// add new pregnancy form page
$router->get(
    '/pregnancies/create',
    [PregnancyController::class, 'create'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

// add new pregnancy form submission
$router->post(
    '/pregnancies/create',
    [PregnancyController::class, 'store'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

// get high risk pregnancies
$router->get(
    '/pregnancies/high-risk',
    [PregnancyController::class, 'highRisk'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

// get expected deliveries
$router->get(
    '/pregnancies/expected-deliveries',
    [PregnancyController::class, 'expectedDeliveries'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

// visits abd follow-ups
$router->get(
    '/pregnancies/visits',
    [PregnancyController::class, 'visits'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

// birth outcomes
$router->get(
    '/pregnancies/birth-outcomes',
    [PregnancyController::class, 'birthOutcomes'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

// pregnancy reports
$router->get(
    '/pregnancies/reports',
    [PregnancyController::class, 'reports'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

// expected delivery date calculator
$router->get(
    '/pregnancies/edd-calculator',
    [PregnancyController::class, 'showEddCalculator'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

// expected delivery date calculator form submission
$router->post(
    '/pregnancies/edd-calculator',
    [PregnancyController::class, 'calculateEdd'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);


// get individual pregnancy details
$router->get(
    '/pregnancies/{id}/birth-outcome',
    [PregnancyController::class, 'recordBirthOutcome'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

$router->post(
    '/pregnancies/{id}/birth-outcome',
    [PregnancyController::class, 'storeBirthOutcome'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

// get individual pregnancy details
$router->get(
    '/pregnancies/{id}',
    [PregnancyController::class, 'show'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

// edit pregnancy form page
$router->get(
    '/pregnancies/{id}/edit',
    [PregnancyController::class, 'edit'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

// edit pregnancy form submission
$router->post(
    '/pregnancies/{id}/edit',
    [PregnancyController::class, 'update'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);

// delete pregnancy form submission
$router->post(
    '/pregnancies/{id}/delete',
    [PregnancyController::class, 'delete'],
    [
        AuthMiddleware::class,
        [AccessCtrlMiddleware::class, ['Administrator']],
    ]
);
