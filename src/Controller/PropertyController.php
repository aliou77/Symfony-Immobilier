<?php

namespace App\Controller;

use App\Entity\Property;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PropertyController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/properties', name: 'property.index')]
    public function index(): Response
    {
        $repo = $this->em->getRepository(Property::class);
        $properties = $repo->findAllVisible();
        return $this->render('property/index.html.twig', [
            'controller_name' => 'PropertyController',
            'current_menu' => 'properties'
        ]);
    }

    #[Route('/properties/{slug}-{id}', name: 'property.show', requirements: ['slug' => "[A-Za-z0-9\-]*"])]
    public function show($slug, $id, Property $property): Response
    {
        if($slug !== $property->getSlug()){
            return $this->redirectToRoute('property.show', [
                    'slug' => $property->getSlug(), 
                    'id' => $property->getId()
                ], 301);
        }
        $result = $this->em->getRepository(Property::class)->find($id);
        return $this->render('property/show.html.twig', [
            'controller_name' => 'PropertyController',
            'property' => $result,
        ]);
    }
}
