<?php
// get(endpoint_url, controller, controller_action_method)

/** @var Router $router */


// NOTE Families
// family overview page
$router->get(
	'/families',
	[FamilyController::class, 'index'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// family list page
$router->get(
	'/families/registry',
	[FamilyController::class, 'registry'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// add new family form page
$router->get(
	'/families/create',
	[FamilyController::class, 'create'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// add new family form submission
$router->post(
	'/families/create',
	[FamilyController::class, 'store'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// household details for all families
$router->get(
	'/families/households',
	[FamilyController::class, 'households'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// reports page
$router->get(
	'/families/reports',
	[FamilyController::class, 'reports'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

//NOTE Family Members


// family members list for a single family
$router->get(
	'/families/{id}/members',
	[FamilyMemberController::class, 'index'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);
// display family members page
$router->get(
	'/families/{id}/members/{memberId}',
	[FamilyMemberController::class, 'show'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);


// display form to add a new family member
$router->get(
	'/families/{id}/members/create',
	[FamilyMemberController::class, 'create'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// handle submission of new family member form
$router->post(
	'/families/{id}/members/create',
	[FamilyMemberController::class, 'store'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// display form to edit a family member
$router->get(
	'/families/{id}/members/{memberId}/edit',
	[FamilyMemberController::class, 'edit'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// handle submission of edit family member form
$router->post(
	'/families/{id}/members/{memberId}/update',
	[FamilyMemberController::class, 'update'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// handle removal of a family member from the family
$router->post(
	'/families/{id}/members/{memberId}/remove',
	[FamilyMemberController::class, 'remove'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);


// NOTE Selected family children
// list of children for a single family
$router->get(
	'/families/{id}/children',
	[ChildController::class, 'byFamily'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);


//NOTE Selected family household
$router->get(
	'/families/{id}/household',
	[FamilyHomeController::class, 'index'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);


// NOTE Selected family guardianship

$router->get(
	'/families/{id}/guardianship',
	[GuardianshipController::class, 'index'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

$router->get(
	'/families/{id}/guardianship/create',
	[GuardianshipController::class, 'create'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

$router->post(
	'/families/{id}/guardianship/create',
	[GuardianshipController::class, 'store'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// $router->get('/families/{id}/guardianship/{guardianshipId}/edit','GuardianshipController','edit');

// $router->post('/families/{id}/guardianship/{guardianshipId}/update','GuardianshipController','update');

$router->post(
	'/families/{id}/guardianship/{guardianshipId}/end',
	[GuardianshipController::class, 'end'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);


// NOTE Selected family home
// home details for a single family
$router->get(
	'/families/{id}/home',
	[FamilyHomeController::class, 'index'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// display form to edit home details for a single family
$router->get(
	'/families/{id}/home/edit',
	[FamilyHomeController::class, 'edit'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

// handle submission of edit home details form for a single family
$router->post(
	'/families/{id}/home/update',
	[FamilyHomeController::class, 'update'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);


// NOTE field visits for selected family

$router->get(
	'/families/{id}/field-visits',
	[FieldVisitController::class, 'byFamily'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);



// NOTE Individual Family records

$router->get(
	'/families/{id}',
	[FamilyController::class, 'show'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

$router->get(
	'/families/{id}/edit',
	[FamilyController::class, 'edit'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

$router->post(
	'/families/{id}/update',
	[FamilyController::class, 'update'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);

$router->post(
	'/families/{id}/delete',
	[FamilyController::class, 'delete'],
	[
		AuthMiddleware::class,
		[AccessCtrlMiddleware::class, ['Administrator']],
	]
);
