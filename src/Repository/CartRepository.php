<?php

namespace App\Repository;

use App\Entity\Cart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<Cart>
 *
 * @method Cart|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cart|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cart[]    findAll()
 * @method Cart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    //    /**
    //     * @return Cart[] Returns an array of Cart objects
    //     */

    public function findByOrders($value): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.fk_userID = :val')
            ->andWhere('u.order_date IS NOT NULL')
            ->setParameter('val', $value)
            ->orderBy('u.order_date', 'DESC')
            // ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    // public function getTotalQuantity($value): int
    // {
    //     return $this->createQueryBuilder('c')
    //         ->select('SUM(c.quantity) as totalQuantity')

    //         ->getQuery()
    //         ->getSingleScalarResult() ?? 0;
    // }


    public function getQtty($value): int
    {
        return $this->createQueryBuilder('c')
            ->select('SUM(c.quantity) as totalQuantity')
            ->andWhere('c.fk_userID = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getSingleScalarResult() ?? 0;
    }


    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Cart
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
