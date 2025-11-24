<?php

// namespace Application/Controller;

class UserController extends Controller
{
	//pour avoir la session pour chaque controleur ! 
	public function __construct()
	{
		if (isset($_SESSION) === false)
		{
			session_start();
		}
	}

	// // PROJET COMPLEX
	// public function user(): void
	// {

	// 	$isHtmxRequest = isset($_SERVER['HTTP_HX_REQUEST']) && $_SERVER['HTTP_HX_REQUEST'] ? 'true' : 'false';
	// 	if ($isHtmxRequest)
	// 	{
	// 		switch ($_GET['user_request'])
	// 		{
	// 			case "sign_in":
	// 				$this->renderView('user/user-form.phtml', ['user_request' => 'sign_in'], $layout = null);
	// 				break;

	// 			default:
	// 				break;
	// 		}
	// 	}

	// 	else
	// 	{
	// 		switch ($_GET['url'])
	// 		{
	// 			case "sign-in":
	// 				$this->renderView('user/sign-up.phtml', ['title' => 'Sign Up']);
	// 				break;

	// 			default:
	// 				break;
	// 		}
	// 	}
	// }


	public function signUp(): void // inscription
	{
		switch ($_SERVER['REQUEST_METHOD'])
		{
			case "GET":
				if (isset($_SERVER['HTTP_HX_REQUEST']) && $_SERVER['HTTP_HX_REQUEST'] === 'true')
				{
					$this->renderView('user/user-form.phtml', ['user_request' => 'sign_up'], $layout = null);
				}

				// else
				// {
				// 	$this->renderView('user/sign-up.phtml', ['title' => 'Sign Up', 'user_request' => 'sign_up']);
				// }

				break;

			case "POST":
				//save form data
				$_SESSION['formSignData'] = $_POST;

				// verif if all data form is present
				if (
					array_key_exists('username', $_POST)
					&& array_key_exists('email', $_POST)
					&& array_key_exists('password', $_POST)
					&& array_key_exists('password_confirm', $_POST)
					&& filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
				)
				{
					// recup de la fonction
					$usersManager = new UsersManager;

					// verif if email is used
					$emailIsKnown = $usersManager->getEmailIsKnown($_POST['email']);
					if ($emailIsKnown)
					{

						$_SESSION['error'] = 'Cette email est déjà utilisé.';
						$user_response_status = 'error';
					}

					// verif if same password
					else if ($_POST['password'] !== $_POST['password_confirm'])
					{

						$_SESSION['error'] = 'Les deux mots de passe doivent être identiques.';
						$user_response_status = 'error';
					}

					else
					{
						// data processing
						$user = new User(
							trim($_POST['username']),
							trim($_POST['email']),
							trim($_POST['password'])
						);
						$user->persist();

						// unset($_SESSION['user']);
						$_SESSION['info'] = 'Inscription réssuie, veuillez vous connecter.';
						$user_response_status = 'success';
					}

					$this->renderView('user/user-response.phtml', ['user_request' => 'sign_up', 'user_response_status' => $user_response_status], $layout = null);
				}
				break;

			default:
				header("Location: /");
				// or die();
				exit();
				break;
		}
	}

	public function signIn(): void // connection
	{
		switch ($_SERVER['REQUEST_METHOD'])
		{
			case "GET":
				// var_dump($_GET);

				if (isset($_SERVER['HTTP_HX_REQUEST']) && $_SERVER['HTTP_HX_REQUEST'] === 'true')
				{
					// $this->renderView('user/user-form.phtml', ['user_request' => 'sign_in'], $layout = null);
					$view = 'user/user-form.phtml';
					$data = ['user_request' => 'sign_in'];
					$layout = null;
				}

				else
				{
					// $this->renderView('home.phtml', ['title' => 'Sign In', 'user_request' => 'sign_in', 'get_request' => 'true']);
					$view = 'home.phtml';
					$data = ['title' => 'Sign In', 'user_request' => 'sign_in', 'get_request' => true];
					$layout = 'base.phtml';
				}

				$this->renderView($view, $data, $layout);

				break;

			case "POST":

				// save form data
				$_SESSION['formSignData'] = $_POST;

				//  Si les différents champs ont été correctement remplis… 
				if (
					array_key_exists('email', $_POST)
					&& array_key_exists('password', $_POST)
					&& filter_var(
						$_POST['email'],
						FILTER_VALIDATE_EMAIL
					)
				)
				{
					//	Récupération de l'utilisateur.
					$usersManager = new UsersManager;
					$user = $usersManager->connectUser(trim($_POST['email']), trim($_POST['password']));
					//  Si un utilisateur a été trouvé et que le mot de passe est correct…
					// 	if($user instanceof User)
					if ($user !== null)
					{
						//  Persist user in session.
						$user->logInSession();

						// cancel data form in session
						unset($_SESSION['formSignData']);


						// 
						$user_response_status = 'success';
					}

					else
					{
						$user_response_status = 'error';
					}
				}
				else
				{
					$user_response_status = 'error';
				}
				$this->renderView('user/user-response.phtml', ['user_request' => 'sign_in', 'user_response_status' => $user_response_status], $layout = null);
				break;

			default:
				header("Location: /");
				// or die();
				exit();
				break;
		}
	}

	public function signOut(): void // deconnection
	{
		unset($_SESSION['user']);

		header('Location: ./');
		exit;
	}

	public function signForget(): void // password reset
	{
		switch ($_SERVER['REQUEST_METHOD'])
		{
			case "GET":

				if (isset($_SERVER['HTTP_HX_REQUEST']) && $_SERVER['HTTP_HX_REQUEST'] === 'true')
				{
					$this->renderView('user/user-form.phtml', ['user_request' => 'sign_forget'], $layout = null);
				}

				// else
				// {
				// 	$this->renderView('user/sign-in.phtml', ['title' => 'Sign Forget']);
				// }

				break;

			case "POST":

				// save form data
				$_SESSION['formSignData'] = $_POST;

				if (!isset($_POST['email']))
				{
					$_SESSION['error'] = "Entrer un email valide";
					$user_response_status = 'error';
				}
				else
				{
					$usersManager = new UsersManager;
					$emailIsKnown = $usersManager->getEmailIsKnown($_POST['email']);

					if (!$emailIsKnown)
					{
						$_SESSION['error'] = "Cette email n'existe pas.";
						$user_response_status = 'error';
					}
					else
					{
						// create new password
						$password = uniqid();
						$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

						$subject = 'Mot de passe oublié';
						$message = "Bonjour, voici votre nouveau mot de passe : $password";
						$headers = 'Content-Type: text/plain; charset="UTF-8"';

						if (mail($_POST['email'], $subject, $message, $headers))
						{
							$usersManager = new UsersManager;
							$usersManager->setNewPasswordByEmail($_POST['email'], $password);

							$_SESSION['error'] = "E-mail envoyé";
							$user_response_status = 'success';
						}
						else
						{
							$_SESSION['error'] = "Une erreur est survenue";
							$user_response_status = 'error';
						}
					}
				}

				$this->renderView('user/user-response.phtml', ['user_request' => 'sign_forget', 'user_response_status' => $user_response_status], $layout = null);

				break;

			default:
				header("Location: /");
				// or die();
				exit();
				break;
		}
	}

	public function profile(): void // profil
	{
		switch ($_SERVER['REQUEST_METHOD'])
		{
			case "GET":

				if (isset($_SERVER['HTTP_HX_REQUEST']) && $_SERVER['HTTP_HX_REQUEST'] === 'true')
				{
					$this->renderView('user/user-form.phtml', ['user_request' => 'user_profile'], $layout = null);
				}

				// else
				// {
				// 	$this->renderView('user/sign-in.phtml', ['title' => 'Sign Forget']);
				// }

				break;

			case "POST":

				// save form data
				$_SESSION['formSignData'] = $_POST;

				if ($_POST['new_username'] !== '')
				{
					$_SESSION['user']->setUsername($_SESSION['user']->getId(), trim($_POST['new_username']));
					$user_response_status = 'success';
				}
				elseif ($_POST['new_email'] !== '')
				{
					if (filter_var($_POST['new_email'], FILTER_VALIDATE_EMAIL))
					{
						// verif if email is used
						$usersManager = new UsersManager; // recup de la fonction
						$emailIsKnown = $usersManager->getEmailIsKnown($_POST['new_email']);

						if ($emailIsKnown)
						{
							$_SESSION['error'] = 'Cette email est déjà utilisé.';

							$user_response_status = 'error';
						}
						else
						{
							$_SESSION['user']->setEmail($_SESSION['user']->getId(), trim($_POST['new_email']));
							$user_response_status = 'success';
						}
					}
				}
				elseif ($_POST['new_password'] !== '')
				{

					if ($_POST['new_password'] !== $_POST['new_password_confirm'])
					{
						$_SESSION['error'] = 'Les deux mots de passe doivent être identiques.';

						$user_response_status = 'error';
					}
					else
					{
						$_SESSION['user']->setPassword($_SESSION['user']->getId(), $_POST['new_password']);
						$user_response_status = 'success';
					}
				}

				$this->renderView('user/user-response.phtml', ['user_request' => 'user_profile', 'user_response_status' => $user_response_status], $layout = null);

				break;

			case "DELETE":

				if (isset($_SESSION['user']))
				{
					$usersManager = new UsersManager;
					$userPassword = $usersManager->getUserPassword($_SESSION['user']->getId());

					if (password_verify($_POST['password'], $userPassword['password']))
					{
						$usersManager = new UsersManager;
						$usersManager->deleteUser($_SESSION['user']->getId());

						unset($_SESSION['user']);

						$_SESSION['info'] = 'Suppression de votre compte réussi.';

						$user_response_status = 'success';
					}
					else
					{
						$_SESSION['error'] = 'Mauvais mot de passe.';

						$user_response_status = 'error';
					}
				}
				else
				{
					$user_response_status = 'error';
				}

				$this->renderView('user/user-response.phtml', ['user_request' => 'user_delete', 'user_response_status' => $user_response_status], $layout = null);

				break;

			default:
				header("Location: /");
				// or die();
				exit();
				break;
		}
	}


	public function profilDelete(): void // confirm delete
	{

		//	display form (GET)
		if ($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			$this->renderView('profil-delete.phtml', ['title' => 'Suppression']);
		}
		//	processing form (POST)
		else
		{
			if (array_key_exists('password', $_POST))
			{
				$usersManager = new UsersManager;
				$userPassword = $usersManager->getUserPassword($_SESSION['user']->getId());

				if (password_verify($_POST['password'], $userPassword['password']))
				{
					$usersManager = new UsersManager;
					$usersManager->deleteUser($_SESSION['user']->getId());

					unset($_SESSION['user']);

					$_SESSION['info'] = 'Suppression de votre compte réussi.';

					header('Location: ./sign-up');
					exit;
				}
				else
				{
					$_SESSION['error'] = 'Mauvais mot de passe.';

					header('Location: ./profil-delete');
					exit;
				}
			}
		}
	}
}
