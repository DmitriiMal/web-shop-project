<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


#[Route('/contact')]
class MailController extends AbstractController
{

    #[Route('/', name: 'app_contact', methods: ['GET', 'POST'])]

    public function sendEmail(MailerInterface $mailer, ContactType $msg, Request $request): Response
    {
        // createFormBuilder is a shortcut to get the "form factory"
        // and then call "createBuilder()" on it
        $msg = "";
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
   
            $email = (new Email())
                ->from("webshopproject4@gmail.com")
                ->to("webshopproject4@gmail.com")
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject("sent with symfony")
                ->text("Message from: " . $data['name'] . "  <" . $data['email'] . ">, Subject: " . $data['subject'] . ", Message: " .$data['message'])
                ->html("Message from:<br><br>" . $data['name'] . "  <code><</code>" . $data['email'] . "<code>></code><br><br> Subject: " . $data['subject'] . "<br><br> Message:<br>" .$data['message']);
            try {
                $mailer->send($email);
                $msg =  new Response("==Your message was successfully sent!");

            } 
            catch (TransportExceptionInterface $error) {
                return  new Response("==Error: " . $error->getMessage());
            }
        }
        
        
        return $this->render('mail/contact.html.twig', [
            'form' => $form->createView(),
            'msg' => $msg
        ]);


    }
}
