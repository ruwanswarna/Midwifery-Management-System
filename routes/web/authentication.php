<?php
// get(endpoint_url, controller, controller_action_method)

/** @var Router $router */

// NOTE Authentication
// display login page
$router->get(
    '/login',
    [AuthController::class, 'indexLogin']
);

// submit login form data
$router->post(
    '/login',
    [AuthController::class, 'login']
);

// display register page
$router->get(
    '/register',
    [AuthController::class, 'indexRegister']
);

// submit register form data
$router->post(
    '/register',
    [AuthController::class, 'register']
);

// logout user
$router->get(
    '/logout',
    [AuthController::class, 'logout']
);
