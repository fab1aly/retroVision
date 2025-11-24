<?php

// namespace Application/Controller;

class FilmController extends Controller
{
    //pour avoir la session pour chaque controleur ! 
    public function __construct()
    {
        if (isset($_SESSION) === false)
        {
            session_start();
        }
    }

    public function film(): void // inscription
    {
        switch ($_SERVER['REQUEST_METHOD'])
        {
            case "GET":

                if (array_key_exists('id', $_GET))
                {
                    $filmsManager = new FilmsManager;
                    $film_data = $filmsManager->getFilmDataByImdbID($_GET['id']);
                }
                // var_dump($film_data);
                // exit;


                // Vérifier si la requête est une requête HTMX (HX-Request
                if (isset($_SERVER['HTTP_HX_REQUEST']) && $_SERVER['HTTP_HX_REQUEST'] === 'true')
                {
                    $this->renderView('film.phtml', ['film_data' => $film_data], $layout = null);
                }
                else
                {
                    $this->renderView('film.phtml', ['title' => 'retroVision', 'film_data' => $film_data]);
                }
                break;

            case "POST":

                break;

            default:
                break;
        }
    }
}
