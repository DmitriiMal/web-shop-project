<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;

#[Route('/mail')]
class MailController extends AbstractController
{


    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]

    public function sendEmail(MailerInterface $mailer): Response
    {
        // createFormBuilder is a shortcut to get the "form factory"
        // and then call "createBuilder()" on it

            $form= $this->createForm(ContactType::class);

        if ($form->isSubmitted() && $form->isValid()) {

            $email = (new Email())
                ->from("rundacodefactory@gmail.com")
                ->to("rundacodefactory@gmail.com")
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject("sent with symfony")
                ->text("hello from symfony");
            try {
                $mailer->send($email);
                return new Response("Email sent!");
            } catch (TransportExceptionInterface $error) {
                return new Response("Error: " . $error->getMessage());
            }
        }
        return $this->render('mail/contact.html.twig', [
            'form' => $form->createView(),
        ]);


    }
}
