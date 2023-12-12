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

use App\Service\FileUploader;

#[Route('/category')]
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
    public function new(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $fkCategory = new FkCategory();
        $form = $this->createForm(FkCategoryType::class, $fkCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('picture')->getData();
            if ($picture) {
                $pictureFileName = $fileUploader->upload($picture);
            }else{
                $pictureFileName = "default_category.jpg";
            }
            $fkCategory->setPicture($pictureFileName);

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
    public function edit(Request $request, FkCategory $fkCategory, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(FkCategoryType::class, $fkCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('picture')->getData(); // this is from the form (new picture)
            if ($picture) {
                if ($fkCategory->getPicture() != "default_category.jpg"){
                    unlink($this->getParameter("picture_directory") . "/". $fkCategory->getPicture()); // from product old picture
                }

                $pictureFileName = $fileUploader->upload($picture);
                $fkCategory->setPicture($pictureFileName);
            }

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
        if ($this->isCsrfTokenValid('delete' . $fkCategory->getId(), $request->request->get('_token'))) {
            if ($fkCategory->getPicture() != "default_category.jpg"){
                unlink($this->getParameter("picture_directory") . "/". $fkCategory->getPicture()); // from product old picture
            }

            $entityManager->remove($fkCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_fk_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
