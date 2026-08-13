<?php
// get(endpoint_url, controller, controller_action_method)

/** @var Router $router */


// NOTE Mothers
// mother overview page
$router->get(
	'/mothers',
	[MotherController::class, 'index'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// mother list page
$router->get(
	'/mothers/registry',
	[MotherController::class, 'registry'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);


// add new mother form submission
$router->post(
	'/mothers/create',
	[MotherController::class, 'store'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// list of high risk mothers
$router->get(
	'/mothers/high-risk',
	[MotherController::class, 'highRisk'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// expected deliveries list
$router->get(
	'/mothers/expected-deliveries',
	[MotherController::class, 'expectedDeliveries'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// reports page
$router->get(
	'/mothers/reports',
	[MotherController::class, 'reports'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

//NOTE individual mother
// mother profile page
$router->get(
	'/mothers/{id}',
	[MotherController::class, 'show'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// NOTE individual mother profile pages
//get pregnancy details for a mother
$router->get(
	'/mothers/{id}/pregnancies',
	[PregnancyController::class, 'pregnancyByMother'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// get clinic visits for a mother
$router->get(
	'/mothers/{id}/clinic-visits',
	[MotherController::class, 'clinicVisitsByMother'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// get field visits for a mother
$router->get(
	'/mothers/{id}/field-visits',
	[MotherController::class, 'fieldVisitsByMother'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// get supplements for a mother
$router->get(
	'/mothers/{id}/supplements',
	[SupplimentDistController::class, 'showMotherSuppliments'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// edit mother form page
$router->get(
	'/mothers/{id}/edit',
	[MotherController::class, 'edit'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// edit mother form submission
$router->post(
	'/mothers/{id}/edit',
	[MotherController::class, 'update'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// delete mother form submission
$router->post(
	'/mothers/{id}/delete',
	[MotherController::class, 'delete'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

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
