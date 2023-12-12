<?php

namespace App\Controller;

use App\Entity\FkCategory;
use App\Form\FkCategoryType;
use App\Repository\FkCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/fk/category')]
class FkCategoryController extends AbstractController
{
    #[Route('/', name: 'app_fk_category_index', methods: ['GET'])]
    public function index(FkCategoryRepository $fkCategoryRepository): Response
    {
        return $this->render('fk_category/index.html.twig', [
            'fk_categories' => $fkCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_fk_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $fkCategory = new FkCategory();
        $form = $this->createForm(FkCategoryType::class, $fkCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($fkCategory);
            $entityManager->flush();

            return $this->redirectToRoute('app_fk_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('fk_category/new.html.twig', [
            'fk_category' => $fkCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_fk_category_show', methods: ['GET'])]
    public function show(FkCategory $fkCategory): Response
    {
        return $this->render('fk_category/show.html.twig', [
            'fk_category' => $fkCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_fk_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FkCategory $fkCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FkCategoryType::class, $fkCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_fk_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('fk_category/edit.html.twig', [
            'fk_category' => $fkCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_fk_category_delete', methods: ['POST'])]
    public function delete(Request $request, FkCategory $fkCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fkCategory->getId(), $request->request->get('_token'))) {
            $entityManager->remove($fkCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_fk_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
