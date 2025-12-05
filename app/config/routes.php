<?php

use app\controllers\ApiExampleController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

// Ensure $app is available
$app = Flight::app();

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function (Router $router) use ($app) {

	$router->get('/', [\app\controllers\HomeController::class, 'home']);
	$router->post('/', [\app\controllers\HomeController::class, 'home']);

	// $router->get('/hello-world/@name', function ($name) {
	// 	echo '<h1>Hello world! Oh hey ' . $name . '!</h1>';
	// });

	// $router->group('/api', function () use ($router) {
	// 	$router->get('/users', [ApiExampleController::class, 'getUsers']);
	// 	$router->get('/users/@id:[0-9]', [ApiExampleController::class, 'getUser']);
	// 	$router->post('/users/@id:[0-9]', [ApiExampleController::class, 'updateUser']);
	// });

	// User Routes
	$router->group('/user', function () use ($router) {
		$router->get('/sign-in', [\app\controllers\UserController::class, 'signIn']);
		$router->post('/sign-in', [\app\controllers\UserController::class, 'signIn']);

		$router->get('/sign-up', [\app\controllers\UserController::class, 'signUp']);
		$router->post('/sign-up', [\app\controllers\UserController::class, 'signUp']);

		$router->get('/profile', [\app\controllers\UserController::class, 'profile']);
		$router->post('/profile', [\app\controllers\UserController::class, 'profile']);
		$router->delete('/profile', [\app\controllers\UserController::class, 'profile']);

		$router->get('/logout', [\app\controllers\UserController::class, 'signOut']);
		$router->post('/logout', [\app\controllers\UserController::class, 'signOut']);

		$router->get('/forget', [\app\controllers\UserController::class, 'signForget']);
		$router->post('/forget', [\app\controllers\UserController::class, 'signForget']);
	});

}, [SecurityHeadersMiddleware::class]);
