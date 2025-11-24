<?php


// namespace Application/Controller;

class RouteController extends Controller
{
    // //pour avoir la session pour chaque controleur ! 
    // public function __construct()
    // {
    //     session_start();
    // }

    public function route(): void
    {
        session_start();
        // var_dump($_GET);
        // exit;
        //	 (GET)
        if ($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            if (array_key_exists('id', $_GET))
            {
                $listsManager = new ListsManager;
                $list = $listsManager->getList($_GET['id']);

                // var_dump($list);
                $this->renderView('route.phtml', ['title' => 'Route', 'lists' => [$list]]);
            }
            else
            {
                header('Location: ./'); //redirction vers home
                exit;
            }
        }
    }

    public function routes(): void
    {
        session_start();
        // var_dump($_POST);
        // exit;
        //	 (GET)
        if ($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            if (array_key_exists('user', $_SESSION))
            {
                $listsManager = new ListsManager;
                $lists = $listsManager->getListsByUserId($_SESSION['user']->getId());

                $this->renderView('routes.phtml', ['title' => 'Routes', 'lists' => $lists]);
            }
            else
            {
                header('Location: ./sign-in'); //redirction vers sign-in
                exit;
            }
        }
    }

    public function routesProcess(): void
    {
        session_start();
        // var_dump($_POST);
        // exit;

        if (array_key_exists('user', $_SESSION))
        {
            // var_dump($_POST);
            // var_dump($_SESSION['user']->getId());
            // exit;
            if (array_key_exists('listpoint', $_POST))
            {

                $uniqid = uniqid();
                $listsManager = new ListsManager;
                $listsManager->saveList($_SESSION['user']->getId(), $_POST['name'], $_POST['listpoint'], $uniqid);

                header('Location: ./routes');
                exit;
            }

            if (array_key_exists('uniq_id_list_remove', $_POST))
            {

                $listsManager = new ListsManager;
                $listsManager->removeList($_SESSION['user']->getId(), $_POST['uniq_id_list_remove']);

                header('Location: ./routes');
                exit;
            }
        }
        else
        {
            header('Location: ./sign-in'); //redirction vers sign-in
            exit;
        }
    }
}
