<?php
// get(endpoint_url, controller, controller_action_method)

/** @var Router $router */

// // NOTE Dashboard
// $router->get('/', 'DashboardController', 'index');
// $router->get('/dashboard', 'DashboardController', 'index');

// // NOTE Authentication
// $router->get('/login', 'AuthController', 'indexLogin'); // to display login page

// $router->post('/login', 'AuthController', 'login'); // submit login form data

// $router->get('/register', 'AuthController', 'indexRegister'); // to display login page

// $router->post('/register', 'AuthController', 'register'); // submit register form data

// $router->get('/logout', 'AuthController', 'logout');

// // NOTE Mothers
// $router->get('/mothers', 'MotherController', 'index');

// $router->get('/mothers/create', 'MotherController', 'create');

// $router->post('/mothers/create', 'MotherController', 'store');

// $router->get('/mothers/{id}', 'MotherController', 'show');

// $router->get('/mothers/edit/{id}', 'MotherController', 'edit');

// $router->post('/mothers/edit/{id}', 'MotherController', 'update');

// $router->post('/mothers/delete/{id}', 'MotherController', 'destroy');

// // NOTE Users
// $router->get('/users', 'UserController', 'index');

// $router->get('/users/create', 'UserController', 'create');

// $router->post('/users/create', 'UserController', 'store');

// $router->get('/users/{id}', 'UserController', 'show');

// $router->get('/users/edit/{id}', 'UserController', 'edit');

// $router->post('/users/edit/{id}', 'UserController', 'update');

// $router->post('/musers/delete/{id}', 'UserController', 'destroy');
// BUG - FIXME: keep this route order as it is to avoid route matching issues. The /children/growth route and /children/vaccinations route must be defined before the /children/{id} route to prevent conflicts.
$basePath = ROOT_PATH . '/routes/web';
require_once  $basePath . '/dashboard.php';
require_once  $basePath . '/authentication.php';
require_once $basePath . '/supplements.php';
require_once  $basePath . '/mothers.php';
require_once  $basePath . '/users.php';
require_once  $basePath . '/pregnancies.php';
require_once  $basePath . '/families.php';
require_once  $basePath . '/clinics.php';
require_once  $basePath . '/field-visits.php';
require_once  $basePath . '/growth.php';
require_once  $basePath . '/vaccinations.php';
require_once  $basePath . '/children.php';
require_once  $basePath . '/reports.php';
