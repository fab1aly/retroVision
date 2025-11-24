<?php

// namespace Application/Controller;

class HomeController extends Controller
{
	//pour avoir la session pour chaque controleur ! 
	public function __construct()
	{
		if (isset($_SESSION) === false) {
			session_start();
		}
	}

	public function test(): void
	{
		// if ($_SERVER['REQUEST_METHOD'] == 'GET')
		// {
		var_dump($_SERVER['REQUEST_METHOD']);
		exit;
		// $this->renderView('home.phtml', ['title' => 'retroVision']);
		// }
	}

	public function home(): void
	{

		switch ($_SERVER['REQUEST_METHOD']) {
			case "GET":
				if (isset($_SERVER['HTTP_HX_REQUEST']) && $_SERVER['HTTP_HX_REQUEST'] === 'true') {
					$this->renderView('home.phtml', [], $layout = null);
				} else {
					$this->renderView('home.phtml', ['title' => 'retroVision']);
				}

				break;

			// case "POST":
			//     return $this->render('view/home.html.twig', [
			//         'controller_name' => 'IndexController',
			//     ]);
			//     break;

			default:
				header("Location: /");
				// or die();
				exit();
		}
	}
}
