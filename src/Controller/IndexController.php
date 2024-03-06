<?php

namespace App\Controller;

use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestMatcher\MethodRequestMatcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('view/home.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/home', name: 'app_home')]
    public function home(Request $request): Response
    {
        switch ($request->getMethod()) {
            case "GET":
                return $this->render('view/home.html.twig', [
                    'controller_name' => 'IndexController',
                ]);
                break;
            case "POST":
                return $this->render('main/home.html.twig', [
                    'controller_name' => 'IndexController',
                ]);
                break;
        }
    }
}
