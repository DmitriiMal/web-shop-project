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

    #[Route('/{id}/userAccess', name: 'app_user_access_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }
}
