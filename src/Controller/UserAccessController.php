<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;

#[Route('/user')]
class UserAccessController extends AbstractController
{
    #[Route('/', name: 'app_user', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('user_access/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }
}
