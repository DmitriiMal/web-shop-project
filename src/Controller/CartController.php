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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/cart')]
class CartController extends AbstractController
{
    #[Route('/', name: 'app_cart_show', methods: ['GET'])]
    public function Cart(ProductRepository $productRepository, CartRepository $cartRepository): Response
    {
        $id = $this->getUser()->getId();
        $totalQuantity = $cartRepository->getQtty($id);
        $user = $this->getUser();

        return $this->render('cart/index.html.twig', [
            'cartObj' => $cartRepository->findBy(['fk_userID' => $user]),
            'totalQuantity' => $totalQuantity,
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

        $user = $this->getUser()->getId();
        $totalQuantity = $cartRepository->getQtty($user);

        $product = $cartRepository->find($id);
        if ($product != null) {

            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->render('cart/index.html.twig', [
            'cartObj' => $cartRepository->findBy(['fk_userID' => $user]),
            'totalQuantity' => $totalQuantity,
        ]);
    }


    #[Route('/plus/{id}', name: 'app_cart_plus', methods: ['GET', 'POST'])]
    public function plusCart(EntityManagerInterface $entityManager, CartRepository $cartRepository, int $id)
    {

        $cart = $cartRepository->find($id);
        $qtty = $cart->getQuantity();
        $price = $cart->getPrice();
        $cart->setQuantity($qtty + 1);
        $summOfCard = $price * $qtty;

        $entityManager->persist($cart);
        $entityManager->flush();

        // return new JsonResponse([$qtty + 1, $cart->getPrice()]);

        return new JsonResponse([$qtty + 1, $price, $this->getTotalQuantity($cartRepository)]);
    }


    #[Route('/minus/{id}', name: 'app_cart_minus', methods: ['GET', 'POST'])]
    public function minusCart(EntityManagerInterface $entityManager, CartRepository $cartRepository, int $id)
    {

        $cart = $cartRepository->find($id);
        $qtty = $cart->getQuantity();
        $cart->setQuantity($qtty - 1);
        if (($qtty - 1) <= 0) {
            return $this->redirectToRoute('app_cart_delete', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        $entityManager->persist($cart);
        $entityManager->flush();

        return new JsonResponse([
            $qtty - 1, $cart->getPrice(), $this->getTotalQuantity($cartRepository)
        ]);
    }

    private function getTotalQuantity(CartRepository $cartRepository): int
    {

        $id = $this->getUser()->getId();
        $totalQuantity = $cartRepository->getQtty($id);
        return $totalQuantity;
    }


    // #[Route('/navbar', name: 'app_cart_navbar', methods: ['GET'])]
    // public function Navbar(ProductRepository $productRepository, CartRepository $cartRepository): Response
    // {

    //     $totalQuantity = $cartRepository->getTotalQuantity();

    //     return new JsonResponse(
    //         $this->getTotalQuantity($cartRepository)
    //     );
    // }
}
