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
    #[Route('/', name: 'index.root')]
    public function index(): Response
    {
        header('Location: ./home');
        // or die();
        exit();
    }

    #[Route('/home', name: 'index.home')]
    public function home(Request $request): Response
    {
        switch ($request->getMethod()) {
            case "GET":
                if ($request->headers->get('HX-Request')){
                    return $this->render('main/home.html.twig', [
                        'controller_name' => 'IndexController',
                    ]);
                }
        
                else {
                    return $this->render('view/home.html.twig', [
                        'controller_name' => 'IndexController',
                    ]);
                }
            break;

            // case "POST":
            //     return $this->render('view/home.html.twig', [
            //         'controller_name' => 'IndexController',
            //     ]);
            //     break;

            default:
                header("Location: /home");
                // or die();
                exit();
            break;
        }
    }
}
