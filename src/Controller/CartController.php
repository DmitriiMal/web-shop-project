<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class CartController extends AbstractController
{
    #[Route('/cart/{o
        ', name: 'app_cart')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        return $this->render('cart/index.html.twig', [
            
        ]);
    }
}
