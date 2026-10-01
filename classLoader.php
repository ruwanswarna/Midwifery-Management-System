<?php

declare(strict_types=1);

// // Define Root Path
// define(
//     'ROOT_PATH',
//     __DIR__
// );
// __DIR__ -gives the absolute directory path of the current file
// D:\MOMS\project - moms

// Start Sesion
// session_start();


// Load Configuration
require_once ROOT_PATH . '/config/constants.php';
require_once ROOT_PATH . '/config/app.php';
require_once ROOT_PATH . '/config/database.php';
require_once ROOT_PATH . '/config/anthroApi.php';

// Load Helper Functions
require ROOT_PATH . '/app/helpers/functions.php';

// auto load all the files in a directory
// You tell PHP where it is by calling spl_autoload_register()
// can only be used for classes, not functions or constants
spl_autoload_register(function (string $class): void {
	// search app directories for the class file
	$directories = [
		ROOT_PATH . '/app/Core/',
		ROOT_PATH . '/app/Exceptions/',
		ROOT_PATH . '/app/Middleware/',
		ROOT_PATH . '/app/Navigation/',
	];

	foreach ($directories as $directory) {
		$file = $directory . $class . '.php';
		if (is_file($file)) {
			require $file;
			return;
		}
	}

	// Search Controllers recursively
	$controllerIterator = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator(
			ROOT_PATH . '/app/Controllers',
			RecursiveDirectoryIterator::SKIP_DOTS
		)
	);

	foreach ($controllerIterator as $file) {

		if (
			$file->isFile() &&
			$file->getExtension() === 'php' &&
			$file->getBasename('.php') === $class
		) {
			require $file->getPathname();
			return;
		}
	}


	// Search module directories
	$moduleDirectories = glob(
		ROOT_PATH . '/app/Modules/*',
		GLOB_ONLYDIR
	);
	foreach ($moduleDirectories as $module) {

		foreach (['Services', 'Repositories', 'Validation'] as $folder) {

			$file = $module . '/' . $folder . '/' . $class . '.php';

			if (is_file($file)) {

				require $file;
				return;
			}
		}
	}

	throw new Exception("Class '{$class}' not found.");
});

// Load Core Classes
// require ROOT_PATH . '/app/Core/App.php';
// require ROOT_PATH . '/app/Core/Router.php';
// require ROOT_PATH . '/app/Core/Request.php';
// require ROOT_PATH . '/app/Core/Response.php';
// require ROOT_PATH . '/app/Core/View.php';
// require ROOT_PATH . '/app/Core/Controller.php';
// require ROOT_PATH . '/app/Core/Database.php';
// require ROOT_PATH . '/app/Core/Session.php';
// require ROOT_PATH . '/app/Core/Auth.php';
// require ROOT_PATH . '/app/Core/Validator.php';


// Load Base Repository
// require ROOT_PATH . '/app/Repositories/Repository.php';



// Load Repositories
// require ROOT_PATH . '/app/Repositories/UserRepository.php';
// require ROOT_PATH . '/app/Repositories/MotherRepository.php';

// Load Services
// require ROOT_PATH . '/app/Services/AuthService.php';
// require ROOT_PATH . '/app/Services/ChildService.php';
// require ROOT_PATH . '/app/Services/UserService.php';
// require ROOT_PATH . '/app/Services/PregnancyService.php';
// require ROOT_PATH . '/app/Services/MotherService.php';
// require ROOT_PATH . '/app/Services/DashboardService.php';



// Load Validators
// require ROOT_PATH . '/app/Validation/LoginValidator.php';
// require ROOT_PATH . '/app/Validation/MotherValidator.php';
// require ROOT_PATH . '/app/Validation/UserValidator.php';


// Load Middleware
// require ROOT_PATH . '/app/Middleware/AuthMiddleware.php';
// require ROOT_PATH . '/app/Middleware/GuestMiddleware.php';
// require ROOT_PATH . '/app/Middleware/RoleMiddleware.php';



// Load Controllers
// require ROOT_PATH . '/app/Controllers/AuthController.php';
// require ROOT_PATH . '/app/Controllers/DashboardController.php';
// require ROOT_PATH . '/app/Controllers/UserController.php';
// require ROOT_PATH . '/app/Controllers/ClinicController.php';
// require ROOT_PATH . '/app/Controllers/MotherController.php';
// require ROOT_PATH . '/app/Controllers/PregnancyController.php';
// require ROOT_PATH . '/app/Controllers/VaccineController.php';
