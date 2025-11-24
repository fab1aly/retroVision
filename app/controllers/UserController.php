<?php

namespace app\controllers;

use app\models\User;
use flight\Engine;

class UserController
{
    protected Engine $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function login()
    {
        if ($this->app->request()->method === 'GET') {
            $this->app->render('auth/login', ['title' => 'Login']);
            return;
        }

        $data = $this->app->request()->data;
        $email = $data->email;
        $password = $data->password;

        $userModel = new User($this->app->db());
        $user = $userModel->findByEmail($email);

        if ($user && $user->verifyPassword($password)) {
            $session = $this->app->session();
            $session->set('user_id', $user->id);
            $session->set('username', $user->username);

            $this->app->redirect('/profile');
        } else {
            $this->app->render('auth/login', ['title' => 'Login', 'error' => 'Invalid credentials']);
        }
    }

    public function register()
    {
        if ($this->app->request()->method === 'GET') {
            $this->app->render('auth/register', ['title' => 'Register']);
            return;
        }

        $data = $this->app->request()->data;
        $username = $data->username;
        $email = $data->email;
        $password = $data->password;

        $userModel = new User($this->app->db());

        if ($userModel->findByEmail($email)) {
            $this->app->render('auth/register', ['title' => 'Register', 'error' => 'Email already exists']);
            return;
        }

        $userModel->create($username, $email, $password);
        $this->app->redirect('/login');
    }

    public function logout()
    {
        $this->app->session()->destroy();
        $this->app->redirect('/');
    }

    public function profile()
    {
        $session = $this->app->session();
        if (!$session->has('user_id')) {
            $this->app->redirect('/login');
            return;
        }

        $userModel = new User($this->app->db());
        $user = $userModel->findByEmail($this->app->db()->query("SELECT email FROM Users WHERE id = " . $session->get('user_id'))->fetchColumn());
        // Note: Ideally we should have a findById method

        $this->app->render('auth/profile', ['title' => 'Profile', 'user' => $user]);
    }
}
