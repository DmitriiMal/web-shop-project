<?php

namespace App\Controller;

use App\Entity\Reviews;
use App\Repository\CartRepository;
use App\Form\ReviewsType;
use App\Repository\ReviewsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reviews')]
class ReviewsController extends AbstractController
{

    #[Route('/new/{id}', name: 'app_reviews_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,CartRepository $carts, $id): Response
    {
        $review = new Reviews();
        $form = $this->createForm(ReviewsType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ----------------
            //   Table Review
            // ----------------
            $IdProduct = $carts->find(["id" => $id])->getFkProduct();
            $IdUser = $carts->find(["id" => $id])->getFkUserID();
            
            // dump($IdProduct);
            // dump($IdUser);
            // die();
            
            $review -> setFkProduct($IdProduct);
            $review -> setFkUser($IdUser);

            $entityManager->persist($review);
            $entityManager->flush();

            // ---------------
            //   Table Cart
            // ---------------
            $cart = $carts->find(["id" => $id]);
            // dump($review->getId());
            // die();
            $cart -> setFkReview($review);
            $entityManager->persist($cart);
            $entityManager->flush();


            //('app_user_show', {'id': app.user.id})
            
            return $this->redirectToRoute('app_user_show', [
                "id"=> $this->getUser()
            ]);
        }


        $picture = $carts->find(["id" => $id])->getFkProduct()->getPicture();
        $nameProduct = $carts->find(["id" => $id])->getFkProduct()->getName();
        $descriptionProduct = $carts->find(["id" => $id])->getFkProduct()->getDescription();

        return $this->render('reviews/new.html.twig', [
            'review' => $review,
            'form' => $form,
            'cart' => $carts->findBy(["id" => $id]),
            'picture' => $picture,
            'nameProduct' => $nameProduct,
            'descriptionProduct' => $descriptionProduct
        ]);
    }

    #[Route('/{id}', name: 'app_reviews_delete', methods: ['POST'])]
    public function delete(Request $request, Reviews $review, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$review->getId(), $request->request->get('_token'))) {
            $entityManager->remove($review);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reviews_index', [], Response::HTTP_SEE_OTHER);
    }
}
