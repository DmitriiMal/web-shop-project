<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaticController extends AbstractController
{
    #[Route('/', name: 'app_static')]
    public function index(): Response
    {
        return $this->render('user_access/index.html.twig', [
            'controller_name' => 'StaticController',
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('static/contact.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }
}
