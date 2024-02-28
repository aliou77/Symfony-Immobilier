<?php

namespace App\EventSubscriber;

use App\Entity\BlogPost;
use App\Entity\Peinture;
use App\Entity\Property;
use DateTime;
use DateTimeImmutable;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class EasyAdminSubscriber implements EventSubscriberInterface{

    private $slugger;
    private $security;

    public function __construct(SluggerInterface $slugger, Security $security)
    {
        $this->slugger = $slugger;
        $this->security = $security;
    }

    public static function getSubscribedEvents(){

        return [
            // lorsque cet evenement sera declancher il appelera la method setBlogPostSlugAndDateaAndUser
            // l'event sera lancer avant le persist des data du nouveau blogpost (easyAdmin) dans la DB.
            BeforeEntityPersistedEvent::class => ["setDateaAndUser"]
        ];
    }

    // NB: EventSubscriber no necessary cause i already set the slug feat at Property class.
    public function setDateaAndUser(BeforeEntityPersistedEvent $event){
        // recupere l'instance parmi les entites qui sont lier a doctrine dans notre projet
        $entity = $event->getEntityInstance();

        if($entity instanceof Property){
            // definition de la date
            $entity->setCreatedAt(new DateTimeImmutable());
            // recupere et definit le user qui s'est connecter au back office (EasyAdmin)
            // $entity->setUser($this->security->getUser()); 
        }
        // if($entity instanceof Peinture){
        //     $entity->setDateRealisation(new DateTime());
        //     $entity->setUser($this->security->getUser()); 
        // }
        // definition du slug apres l'avoir slugifier
        // NB: cette fonctionnalite a ete remplacer par l'autocompletion du slug par EasyAdmin
        // $slug = $this->slugger->slug($entity->getTitre());
        // $entity->setSlug($slug);
        
        return; // si non
    }
}