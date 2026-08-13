<?php
/** @var Router $router */
$guard=[AuthMiddleware::class,[AccessCtrlMiddleware::class,['Administrator']]];$router->get('/reports',[ReportController::class,'index'],$guard);$router->get('/reports/create',[ReportController::class,'create'],$guard);$router->post('/reports/create',[ReportController::class,'store'],$guard);$router->get('/reports/{id}',[ReportController::class,'show'],$guard);
