<?php

namespace App\Controller;

use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('view/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/home', name: 'app_home')]
    public function home(FilmRepository $filmRepository): Response
    {
        return $this->render('main/home.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
}
