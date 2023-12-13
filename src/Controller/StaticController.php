<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaticController extends AbstractController
{
    #[Route('/', name: 'app_static')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('static/index.html.twig', [
            'controller_name' => 'StaticController',
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('static/contact.html.twig', [
            // 'controller_name' => 'ContactController',
        ]);
    }
}
