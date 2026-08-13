<?php

declare(strict_types=1);

$config = require ROOT_PATH . '/config/app.php';

define('APP_NAME', $config['name']);

define('APP_URL', $config['url']);

define('APP_DEBUG', $config['debug']);

date_default_timezone_set($config['timezone']);
