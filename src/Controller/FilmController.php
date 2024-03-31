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
        $films = $filmRepository->findAll();
        // dd($films);

        switch ($request->getMethod()) {
            case "GET":
                return $this->render('view/recent.html.twig', [
                    'controller_name' => 'FilmController',
                    'films' => $films,
                ]);
                break;
            case "POST":
                return $this->render('main/recent.html.twig', [
                    'controller_name' => 'FilmController',
                    'films' => $films,
                ]);
                break;
        }
    }

    #[Route('video={uri}', name: 'film.video', requirements: ['uri' => '[a-z0-9-]+'],)]
    public function video(Request $request, string $uri, FilmRepository $filmRepository): Response
    {
        // $films = $filmRepository->findAll();
        // dd($uri);

        return $this->render('element/video.html.twig', [
            'controller_name' => 'FilmController',
            'uri' => $uri,
        ]);
    }




    #[Route('film', name: 'film.index')]
    public function index(Request $request, FilmRepository $filmRepository): Response
    {
        $films = $filmRepository->findAll();
        // dd($films);

        return $this->render('main/film.main.html.twig', [
            'controller_name' => 'FilmController',
            'films' => $films,
        ]);
    }

    #[Route('film={slug}-{id}', name: 'film.show', requirements: ['id' => '\d+', 'slug' => '[a-z0-9-]+'],)]
    public function show(Request $request, string $slug, int $id): Response
    {
        dd($slug, $id);

        return $this->render('view/film.html.twig', [
            'controller_name' => 'FilmController',
            'slug' => $slug,
            'id' => $id,
        ]);
    }
}
