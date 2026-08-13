<?php
/** @var Router $router */
$guard=[AuthMiddleware::class,[AccessCtrlMiddleware::class,['Administrator']]];
$router->get('/field-visits',[FieldVisitController::class,'index'],$guard);$router->get('/field-visits/create',[FieldVisitController::class,'create'],$guard);$router->post('/field-visits/create',[FieldVisitController::class,'store'],$guard);$router->get('/field-visits/{id}/edit',[FieldVisitController::class,'edit'],$guard);$router->post('/field-visits/{id}/update',[FieldVisitController::class,'update'],$guard);$router->post('/field-visits/{id}/delete',[FieldVisitController::class,'destroy'],$guard);$router->get('/field-visits/{id}',[FieldVisitController::class,'show'],$guard);
