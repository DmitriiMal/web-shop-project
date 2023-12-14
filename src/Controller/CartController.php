<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Cart;
use App\Entity\Product;
use Doctrine\ORM\Mapping\Id;
use App\Repository\ProductRepository;

#[Route('/cart')]
class CartController extends AbstractController
{
    #[Route('/', name: 'app_cart_show', methods: ['GET'])]
    public function Cart(): Response
    {
        return $this->render('cart/index.html.twig', [       
        ]);
    }

    #[Route('/{id}', name: 'app_cart', methods: ['GET', 'POST'])]
    public function addToCart(EntityManagerInterface $entityManager, ProductRepository $productRepository, float $id): Response
    {

        $product = $productRepository -> find($id);
        $price = $product -> getPrice();
        $productID = $product -> getId();
        

        $cartObj = new Cart();
        $cartObj -> setQuantity(1);
        $cartObj -> setBought(false);
        $cartObj -> setPrice($price);

        $entityManager->persist($cartObj);
        $entityManager->flush();

        return $this->render('cart/index.html.twig', [
            'cartObj' => $cartObj,
            'product' => $product   
        ]);
    }
}
