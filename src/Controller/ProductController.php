<?php

namespace App\Controller;

use App\Entity\FkCategory;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Repository\ReviewsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



use App\Service\FileUploader;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'app_product_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(Request $request, PersistenceManagerRegistry $doctrine, ProductRepository $productRepository, ReviewsRepository $reviews): Response
    {

        $category = $request->query->get('fk_categoryID', 'all');
        $entityManager = $doctrine->getManager();
        $allCategory = $doctrine->getRepository(FkCategory::class)->findAll();

        if ($category !== 'all') {
            $products = $entityManager
                ->getRepository(Product::class)
                ->createQueryBuilder('p')
                ->join('p.fk_categoryID', 'c')
                ->andWhere('c.name = :category')
                ->setParameter('category', $category)
                ->getQuery()
                ->getResult();
        } else {
            $products = $doctrine->getRepository(Product::class)->findAll();
        }

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'allCategory' => $allCategory,
            'category' => $category,
            'reviews' => $reviews,
        ]);
    }

    #[Route('/new', name: 'app_product_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('picture')->getData();
            if ($picture) {
                $pictureFileName = $fileUploader->upload($picture, "pictures");
            } else {
                $pictureFileName = "default.png";
            }
            $product->setPicture($pictureFileName);

            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Product $product, ReviewsRepository $review, $id): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
            'review' => $review->findBy(["fk_product" => $id])
        ]);
    }

    #[Route('/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('picture')->getData(); // this is from the form (new picture)
            if ($picture) {
                if ($product->getPicture() != "default.png") {
                    unlink($this->getParameter("picture_directory") . "/" . $product->getPicture()); // from product old picture
                }

                $pictureFileName = $fileUploader->upload($picture, "pictures");
                $product->setPicture($pictureFileName);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_delete', methods: ['POST', 'GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, ProductRepository $productRepository, EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $productRepository->find($id);

        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            if ($product->getPicture() != "default.png") {
                unlink($this->getParameter("picture_directory") . "/" . $product->getPicture()); // from product old picture
            }

            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }
}
