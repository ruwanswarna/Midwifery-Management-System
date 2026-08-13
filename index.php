<?php
// require __DIR__ . '/public/index.php';

declare(strict_types=1);
session_start();
//uncomment this to bypass login page
// $_SESSION['user'] = [
// 	'id' => 1,
// 	'username' => 'admin',
// 	'full_name' => 'System Administrator',
// 	'role_id' => 1,
// 	'role_name' => 'Administrator'
// ];
define('ROOT_PATH', __DIR__);
require ROOT_PATH . '/classLoader.php';
$app = new App();
$app->run();
