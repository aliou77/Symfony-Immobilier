<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(PaginatorInterface $panigator, Request $request): Response
    {
        // form search handler
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){
            // code...
        }

        $repo = $this->em->getRepository(Property::class);
        $query = $repo->findAllVisibleQuery($search);
        $propertiesPagination = $panigator->paginate(
            $query,
            $request->query->getInt('page', 1),
            12
        );
        return $this->render('property/index.html.twig', [
            'controller_name' => 'PropertyController',
            'properties' => $propertiesPagination,
            'current_menu' => 'properties',
            'form' => $form->createView()
        ]);
    }

    #[Route('/properties/{slug}-{id}', name: 'property.show', requirements: ['slug' => "[A-Za-z0-9\-]*"])]
    public function show($slug, $id, Property $property): Response
    {
        // security check for fake slugs
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
