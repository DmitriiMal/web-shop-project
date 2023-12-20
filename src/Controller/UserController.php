<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminType;
use App\Form\UserType;
use App\Repository\CartRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\FileUploader;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/account')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(AdminType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $picture = $form->get('picture')->getData();
            if ($picture) {
                $pictureFileName = $fileUploader->upload($picture, "users");
            } else {
                $pictureFileName = "avatar.png";
            }
            $user->setPicture($pictureFileName);

            $now = new \DateTimeImmutable();
            $user->setCreatedAt($now);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user, CartRepository $cart, $id): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'cart' => $cart->findBy(['fk_userID' => $user, 'bought' => true])
            // 'reviews' => $review->findBy(["fk_user" => $id])
            // 'cart' => $cart->findBy(["fk_userID" => $id, "order_date" => "notnull"],["order_date" => "ASC"])
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, FileUploader $fileUploader, UserPasswordHasherInterface $userPasswordHasher, int $id): Response
    {

        if($this->IsGranted('ROLE_ADMIN')) {
            $form = $this->createForm(AdminType::class, $user);
        }else{
            $form = $this->createForm(UserType::class, $user);
        }
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if(!$this->isGranted('ROLE_ADMIN')){
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
        }

            $picture = $form->get('picture')->getData();
            if ($picture) {
                if ($user->getPicture() != "avatar.png") {
                    unlink($this->getParameter("picture_user_directory") . "/" . $user->getPicture()); // from product old picture
                }

                $pictureFileName = $fileUploader->upload($picture , "users");
                $user->setPicture($pictureFileName);
            }


            $entityManager->flush();

            if(!$this->isGranted('ROLE_ADMIN')){
                return $this->redirectToRoute('app_user_show', ['id' => $id], Response::HTTP_SEE_OTHER);
            }else{
                return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            if ($user->getPicture() != "avatar.png") {
                unlink($this->getParameter("picture_user_directory") . "/" . $user->getPicture()); // from product old picture
            }

            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
