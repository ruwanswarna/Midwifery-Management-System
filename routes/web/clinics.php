<?php

/** @var Router $router */
$guard=[AuthMiddleware::class,[AccessCtrlMiddleware::class,['Administrator']]];
$router->get('/clinics',[ClinicController::class,'index'],$guard);
$router->get('/clinics/create',[ClinicController::class,'create'],$guard);
$router->post('/clinics/create',[ClinicController::class,'store'],$guard);
$router->get('/clinics/{id}/edit',[ClinicController::class,'edit'],$guard);
$router->post('/clinics/{id}/update',[ClinicController::class,'update'],$guard);
$router->post('/clinics/{id}/delete',[ClinicController::class,'destroy'],$guard);
$router->get('/clinics/{id}',[ClinicController::class,'show'],$guard);
