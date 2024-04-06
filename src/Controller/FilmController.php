<?php

namespace App\Controller;

use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FilmController extends AbstractController
{
    #[Route('/recent', name: 'film.recent')]
    public function recent(Request $request, FilmRepository $filmRepository): Response
    {
        $criteria = [];
        $orderBy = ['id' => 'DESC'];
        $limit = 20;
        $offset = null;

        $films = $filmRepository->findBy($criteria, $orderBy, $limit, $offset);
        // dd($films);

        switch ($request->getMethod()) {
            case "GET":
                if ($request->headers->get('HX-Request'))
                {
                    return $this->render('main/recent.html.twig', [
                        'controller_name' => 'FilmController',
                        'films' => $films,
                    ]);
                }
                else
                {
                    return $this->render('view/recent.html.twig', [
                        'controller_name' => 'FilmController',
                        'films' => $films,
                    ]);
                }
            break;

            // case "POST":
            //     return $this->render('main/recent.html.twig', [
            //         'controller_name' => 'FilmController',
            //         'films' => $films,
            //     ]);
            // break;

            default:
                header("Location: /home");
                // or die();
                exit();
            break;
        }
    }

    #[Route('/film={imdb_id}', name: 'film.detail', requirements: ['imdb_id' => '[a-z0-9-]+'],)]
    public function film(Request $request, string $imdb_id, FilmRepository $filmRepository): Response
    {
        $criteria = ["imdbID" => $imdb_id];
        $film = $filmRepository->findOneBy($criteria);

        switch ($request->getMethod()) {
            case "GET":
                if ($request->headers->get('HX-Request'))
                {
                    return $this->render('main/film-detail.html.twig', [
                        'controller_name' => 'FilmController',
                        'film' => $film,
                    ]);
                }
                else
                {
                    return $this->render('view/film.html.twig', [
                        'controller_name' => 'FilmController',
                        'film' => $film,
                    ]);
                }
            break;

            default:
                header("Location: /home");
                // or die();
                exit();
            break;
        }
    }

    #[Route('/video={imdb_id}', name: 'film.video', requirements: ['imdb_id' => '[a-z0-9-]+'],)]
    public function video(Request $request, string $imdb_id, FilmRepository $filmRepository): Response
    {
        $film = $filmRepository->findOneBy(["imdbID" => $imdb_id]);
        // dd($film);

        switch ($request->getMethod()) {
            case "GET":
                if ($request->headers->get('HX-Request'))
                {
                    return $this->render('element/video-webtorrent.html.twig', [
                        'controller_name' => 'FilmController',
                        'film' => $film,
                    ]);
                }
                else
                {
                    header("Location: /film=".$imdb_id);
                    // or die();
                    exit();
                }
            break;

            default:
                header("Location: /home");
                // or die();
                exit();
            break;
        }
    }

    // #[Route('film', name: 'film.index')]
    // public function index(Request $request, FilmRepository $filmRepository): Response
    // {
    //     $films = $filmRepository->findAll();
    //     // dd($films);

    //     return $this->render('main/film.main.html.twig', [
    //         'controller_name' => 'FilmController',
    //         'films' => $films,
    //     ]);
    // }

    // #[Route('film={slug}-{id}', name: 'film.show', requirements: ['id' => '\d+', 'slug' => '[a-z0-9-]+'],)]
    // public function show(Request $request, string $slug, int $id): Response
    // {
    //     dd($slug, $id);

    //     return $this->render('view/film.html.twig', [
    //         'controller_name' => 'FilmController',
    //         'slug' => $slug,
    //         'id' => $id,
    //     ]);
    // }
}
