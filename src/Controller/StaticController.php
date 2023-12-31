<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/static')]
class StaticController extends AbstractController
{
    #[Route('/', name: 'app_static')]
    public function index(ProductRepository $productRepository): Response
    {
        // $session = $this->get('session');
        // $nav_total = $session->get('nav_total');

        return $this->render('static/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    // #[Route('/contact', name: 'app_contact')]
    // public function contact(): Response
    // {
    //     return $this->render('static/contact.html.twig', []);
    // }
}
