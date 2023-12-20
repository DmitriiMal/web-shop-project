<?php

namespace App\Controller;

use App\Repository\CartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/statistics')]
class StatisticsController extends AbstractController
{
    #[Route('/', name: 'app_statistics')]
    public function index(CartRepository $cartRepository): Response
    {
        // dd($cartRepository->getSalesGroupByCategory());
        return $this->render('statistics/index.html.twig', [
            'bycategory' => $cartRepository->getSalesGroupByCategory(),
            'byproduct' => $cartRepository->getSalesGroupByProduct(),
            'byuser' => $cartRepository->getSalesGroupByUser(),
            'byorderdate' => $cartRepository->getSalesGroupByOrderDate()
        ]);
    }
}