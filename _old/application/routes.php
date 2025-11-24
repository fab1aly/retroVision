<?php

return
	[
		'/admin' => 'AdminController::admin',
		'/test' => 'HomeController::test',

		'/' => 'HomeController::home',
		'/home' => 'HomeController::home',
		'/home-process' => 'HomeController::homeProcess',

		'/film' => 'FilmController::film',

		'/sign-up' => 'UserController::signUp',
		'/sign-in' => 'UserController::signIn',
		'/sign-out' => 'UserController::signOut',
		'/sign-forget' => 'UserController::signForget',

		'/profile' => 'UserController::profile',
		'/profile-process' => 'UserController::profilProcess',
		'/profile-delete' => 'UserController::profilDelete',

	];
