<?php

namespace app\controllers;

use flight\Engine;

class HomeController
{
    protected Engine $app;

    public function __construct(Engine $app)
    {
        $this->app = $app;
    }

    /**
     * Home page handler
     * Handles both full page loads and HTMX partial updates
     */
    public function home(): void
    {
        // Check if this is an HTMX request
        $isHtmxRequest = isset($_SERVER['HTTP_HX_REQUEST']) && $_SERVER['HTTP_HX_REQUEST'] === 'true';

        // Get user from session if logged in
        $session = $this->app->session();
        $user = null;
        $userId = $session->get('user_id');
        if ($userId !== null) {
            $user = [
                'id' => $userId,
                'username' => $session->get('username')
            ];
        }

        if ($this->app->request()->method === 'GET') {
            if ($isHtmxRequest) {
                // HTMX request - render only the home content without layout
                $this->app->render('home.latte', ['user' => $user]);
            } else {
                // Regular request - render with full layout
                $this->app->render('home.latte', ['user' => $user], 'mainContent');
                $this->app->render('layout.latte', [
                    'title' => 'retroVision - Home',
                    'mainContent' => $this->app->view()->get('mainContent'),
                    'nonce' => $this->app->get('csp_nonce'),
                    'user' => $user
                ]);
            }
        } elseif ($this->app->request()->method === 'POST') {
            // Handle POST request (e.g., form submission)
            // For now, just redirect to home
            $this->app->redirect('/');
        }
    }
}
