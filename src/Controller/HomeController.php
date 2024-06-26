<?php

namespace App\Controller;

use App\Entity\Property;
use Doctrine\ORM\EntityManagerInterface;
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


    #[Route('/', name: 'home')]
    public function index(EntityManagerInterface $em): Response
    {
        $repo = $em->getRepository(Property::class);
        $properties = $repo->findLatest();
        return new Response( $this->twig->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'properties' => $properties,
            'current_menu' => 'home',
        ]) );
    }
}
