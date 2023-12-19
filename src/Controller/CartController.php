<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Cart;
use Doctrine\ORM\Mapping\Id;
use App\Repository\ProductRepository;
use App\Repository\CartRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/cart')]
class CartController extends AbstractController
{
    #[Route('/', name: 'app_cart_show', methods: ['GET'])]
    public function Cart(ProductRepository $productRepository, CartRepository $cartRepository): Response
    {

        $user = $this->getUser();

        return $this->render('cart/index.html.twig', [
            'cartObj' => $cartRepository->findBy(['fk_userID' => $user])
        ]);
    }

    #[Route('/{id}', name: 'app_cart', methods: ['GET', 'POST'])]
    public function addToCart(EntityManagerInterface $entityManager, ProductRepository $productRepository, CartRepository $cartRepository, UserInterface $user, int $id): Response
    {

        $product = $productRepository->find($id);
        $price = $product->getPrice();

        $user = $this->getUser();

        $cartObj = new Cart();
        $cartObj->setQuantity(1);
        $cartObj->setBought(false);
        $cartObj->setPrice($price);
        $cartObj->setFkProduct($product);
        $cartObj->setFkUserID($user);

        $entityManager->persist($cartObj);
        $entityManager->flush();

        return $this->redirectToRoute('app_cart_show', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/delete/{id}', name: 'app_cart_delete', methods: ['GET', 'POST'])]
    public function deleteFromCart(EntityManagerInterface $entityManager, ProductRepository $productRepository, CartRepository $cartRepository, int $id): Response
    {

        $user = $this->getUser();

        $product = $cartRepository->find($id);
        if ($product != null) {

            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->render('cart/index.html.twig', [
            'cartObj' => $cartRepository->findBy(['fk_userID' => $user])
        ]);
    }


    #[Route('/plus/{id}', name: 'app_cart_plus', methods: ['GET', 'POST'])]
    public function plusCart(EntityManagerInterface $entityManager, ProductRepository $productRepository, CartRepository $cartRepository, int $id)
    {

        $cart = $cartRepository->find($id);
        $qtty = $cart->getQuantity();
        $cart->setQuantity($qtty + 1);

        $entityManager->persist($cart);
        $entityManager->flush();

        return new JsonResponse($qtty + 1);
    }
}
