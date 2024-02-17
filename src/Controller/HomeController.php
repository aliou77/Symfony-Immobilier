<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

class HomeController extends AbstractController
{
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        // use the Twig environment service, initialized in service.yaml
        $this->twig = $twig;
    }


    #[Route('/home', name: 'home')]
    public function index(): Response
    {
        return new Response( $this->twig->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]) );
    }
}
