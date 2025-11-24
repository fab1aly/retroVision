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

	$router->get('/', function () use ($app) {

		$app->render('home.latte', [], 'mainContent');
		$app->render('layout.latte', [
			'title' => 'retroVision - Home',
			'mainContent' => Flight::view()->get('mainContent'),
			'nonce' => $app->get('csp_nonce')
		]);
	});

	// $router->get('/hello-world/@name', function ($name) {
	// 	echo '<h1>Hello world! Oh hey ' . $name . '!</h1>';
	// });

	// $router->group('/api', function () use ($router) {
	// 	$router->get('/users', [ApiExampleController::class, 'getUsers']);
	// 	$router->get('/users/@id:[0-9]', [ApiExampleController::class, 'getUser']);
	// 	$router->post('/users/@id:[0-9]', [ApiExampleController::class, 'updateUser']);
	// });

	// User Auth Routes
	$router->get('/login', [\app\controllers\UserController::class, 'login']);
	$router->post('/login', [\app\controllers\UserController::class, 'login']);

	$router->get('/register', [\app\controllers\UserController::class, 'register']);
	$router->post('/register', [\app\controllers\UserController::class, 'register']);

	$router->get('/logout', [\app\controllers\UserController::class, 'logout']);
	$router->post('/logout', [\app\controllers\UserController::class, 'logout']);

	$router->get('/profile', [\app\controllers\UserController::class, 'profile']);

}, [SecurityHeadersMiddleware::class]);
