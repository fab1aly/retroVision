<?php
// session_start();
// var_dump($_SESSION);
// var_dump($user_info);
try
{
	//	Racine du projet
	define('ROOT', dirname(__DIR__));

	//	Configuration
	define('CONFIGURATION', require ROOT . '/application/configuration.php');

	//	Auto-chargement des classes (Pourrait être amélioré en utilisant les espaces de noms et le standard PSR-4.)
	spl_autoload_register(function (string $class): void
	{
		$folderPaths = ['/application/controllers', '/application/managers', '/application/entities', '/application/core'];

		foreach ($folderPaths as $folderPath)
		{
			$folderPath = ROOT . $folderPath . '/' . $class . '.php';

			if (file_exists($folderPath))
			{
				require $folderPath;
				return;
			}
		}
	});

	//	Routeur
	$routes = require ROOT . '/application/routes.php';
	// $route = ($_SERVER['REQUEST_URI'] ?? null);
	$route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

	// Page index
	if ($route == '/index.php')
	{
		header('Location: ./');
		exit;
	}

	//	Page inexistante
	if (!array_key_exists($route, $routes))
	{
		http_response_code(404);
		exit;
	}

	//	Instanciation du contrôleur et appel de la méthode souhaités
	$parts = explode('::', $routes[$route]);
	// $controller = $parts[0];
	// $method = $parts[1];
	list($controller, $method) = explode('::', $routes[$route]);

	(new $controller)->$method();
}
catch (Throwable $e)
{
	var_dump($e);	//	Uniquement pour le développement.
}
