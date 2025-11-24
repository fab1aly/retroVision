<?php

// namespace Application/Controller;

class AdminController extends Controller
{
    //pour avoir la session pour chaque controleur ! 
    public function __construct()
    {
        if (isset($_SESSION) === false)
        {
            session_start();
        }
    }

    public function admin(): void // home page admin
    {
        switch ($_SERVER['REQUEST_METHOD'])
        {
            case "GET":

                $OMDbAPIKey = getenv('OMDbAPIKey');

                $usersManager = new UsersManager;
                $user_array = $usersManager->getAllUsers();

                $filmsManager = new FilmsManager;
                $film_array = $filmsManager->getAllFilms();

                $torrentsManager = new TorrentsManager;
                $torrent_array = $torrentsManager->getAllTorrents();

                // var_dump($OMDbAPIKey);
                // exit;


                // Vérifier si la requête est une requête HTMX (HX-Request
                if (isset($_SERVER['HTTP_HX_REQUEST']) && $_SERVER['HTTP_HX_REQUEST'] === 'true')
                {
                    $this->renderView(
                        'admin/admin_home.phtml',
                        [
                            'OMDbAPIKey' => $OMDbAPIKey,
                            'user_array' => $user_array,
                            'film_array' => $film_array,
                            'torrent_array' => $torrent_array,
                        ],
                        $layout = null,
                    );
                }
                else
                {
                    $this->renderView(
                        'admin/admin_home.phtml',
                        [
                            'title' => 'retroVision',
                            'OMDbAPIKey' => $OMDbAPIKey,
                            'user_array' => $user_array,
                            'film_array' => $film_array,
                            'torrent_array' => $torrent_array,
                        ],
                    );
                }
                break;

            case "POST":

                break;

            default:
                break;
        }
    }
}
