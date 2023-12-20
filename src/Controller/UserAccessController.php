<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use App\Entity\Product;

use App\Entity\FkCategory;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserAccessController extends AbstractController
{
    #[Route('/', name: 'app_user', methods: ['GET'])]
    public function index(Request $request, PersistenceManagerRegistry $doctrine, ProductRepository $productRepository): Response
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

        return $this->render('user_access/index.html.twig', [
            'products' => $products,
            'allCategory' => $allCategory,
            'category' => $category,
        ]);
    }

    #[Route('/search/{txt}', name: 'app_search', methods: ['GET', 'POST'])]
    public function search(Request $request, PersistenceManagerRegistry $doctrine, ProductRepository $productRepository, string $txt)
    {
        $entityManager = $doctrine->getManager();

        $qb = $entityManager
            ->getRepository(Product::class)
            ->createQueryBuilder('p')
            ->where('p.name like :txt')
            ->setParameter('txt', $txt."%");

        $query = $qb->getQuery();
        $product = $query->execute();
        $out = [];
        foreach($product as $prod){
            $out[] = $prod->getName();
        }

        return new JsonResponse($out);
    }

    #[Route('/filter/', name: 'app_filter', methods: ['GET', 'POST'])]
    public function filter(Request $request, PersistenceManagerRegistry $doctrine, ProductRepository $productRepository)
    {
        $txt = $request->request->get('search');

        $entityManager = $doctrine->getManager();
        $allCategory = $doctrine->getRepository(FkCategory::class)->findAll();


        $qb = $entityManager
            ->getRepository(Product::class)
            ->createQueryBuilder('p')
            ->where('p.name like :txt')
            ->setParameter('txt', $txt."%");

        $query = $qb->getQuery();
        $products = $query->execute();
        
        return $this->render('user_access/index.html.twig', [
            'products' => $products,
            'allCategory' => $allCategory
        ]);
    }

    #[Route('/{id}/userAccess', name: 'app_user_access_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }
}
