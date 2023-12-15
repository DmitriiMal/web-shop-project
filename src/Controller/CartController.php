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
use App\Repository\CartRepository;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/cart')]
class CartController extends AbstractController
{
    #[Route('/', name: 'app_cart_show', methods: ['GET'])]
    public function Cart(ProductRepository $productRepository, CartRepository $cartRepository): Response
    {
        return $this->render('cart/index.html.twig', [ 
            'cartObj' => $cartRepository -> findAll(),
            'product' => $productRepository -> findAll()        
        ]);
    }

    #[Route('/{id}', name: 'app_cart', methods: ['GET', 'POST'])]
    public function addToCart(EntityManagerInterface $entityManager, ProductRepository $productRepository, CartRepository $cartRepository, UserInterface $user, int $id): Response
    {

        $product = $productRepository -> find($id);
        $price = $product -> getPrice();

        $user = $this->getUser();

        $cartObj = new Cart();
        $cartObj -> setQuantity(1);
        $cartObj -> setBought(false);
        $cartObj -> setPrice($price);
        $cartObj -> setFkProduct($product);
        $cartObj -> setFkUserID($user);

        $entityManager->persist($cartObj);
        $entityManager->flush();

        return $this->render('cart/index.html.twig', [
            'cartObj' => $cartRepository -> findAll(),
            'product' => $productRepository -> findAll()  
        ]);
    }

    #[Route('/delete/{id}', name: 'app_cart_delete', methods: ['GET'])]
    public function deleteFromCart(EntityManagerInterface $entityManager, ProductRepository $productRepository, CartRepository $cartRepository, int $id): Response
    {

        $product = $productRepository -> find($id);
        $entityManager -> remove($product);
        $entityManager -> flush();

        return $this->render('cart/index.html.twig', [ 
            'cartObj' => $cartRepository -> findAll(),
            'product' => $productRepository -> findAll()        
        ]);
    }
}
