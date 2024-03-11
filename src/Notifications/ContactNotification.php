<?php

namespace App\Notifications;

use App\Entity\Contact;
use Symfony\Component\Mailer\MailerInterface as Mailer;
use Twig\Environment;
use Symfony\Component\Mime\Email;

/**
 * Class which is responsible for sending email to a user.
 */
class ContactNotification{

    private $mailer;

    private $twig;

    public function __construct(Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function notity(Contact $contact){
        $mail = $contact->getEmail();
        $email = (new Email())
            ->from($contact->getEmail())
            ->to('Helter@contact.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Contact Request')
            ->html($this->twig->render('emails/contact.html.twig', ['contact' => $contact]));
            // ->text("Contact Request from: $mail" );

        $this->mailer->send($email);
    }
}