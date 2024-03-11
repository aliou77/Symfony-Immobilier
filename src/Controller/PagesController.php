<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Notifications\ContactNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PagesController extends AbstractController
{
    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('pages/about.html.twig', [
            'controller_name' => 'PagesController',
            'current_menu' => 'about',
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, ContactNotification $notification): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){
            $notification->notity($contact);
            $this->addFlash('success', 'Your message has been sent successfully.');
            $form = $this->createForm(ContactType::class, new Contact());
        }

        return $this->render('pages/contact.html.twig', [
            'controller_name' => 'PagesController',
            'current_menu' => 'contact',
            'form' => $form->createView(),
        ]);
    }
}
