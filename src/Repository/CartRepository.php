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


    public function getSalesGroupByCategory(): array
    {
        // $sql = "SELECT fk_category.name as name, SUM(cart.quantity) as quantity, SUM(cart.price) as total FROM cart INNER JOIN product ON cart.fk_product_id = product.id INNER JOIN fk_category ON product.fk_category_id_id = fk_category.id WHERE ORDER_DATE is not null GROUP BY product.fk_category_id_id ORDER BY fk_category.name ASC;"

        return $this->createQueryBuilder('c') // c is the cart
            ->select('fkc.name as name, SUM(c.quantity) as quantity, SUM(c.quantity * c.price) as total')
            ->innerJoin("c.fk_product", "fkp") // fkproductid it is onlz an alies 
            ->innerJoin("fkp.fk_categoryID", "fkc") // fkproductid it is onlz an alies 
            ->andWhere('c.order_date IS NOT NULL')
            ->groupBy('fkc.id')
            ->orderBy('fkc.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getSalesGroupByProduct(): array
    {
        //$sql = "SELECT product.name as name, SUM(cart.quantity) as quantity,  product.picture as picture  
        // FROM cart 
        // INNER JOIN product ON cart.fk_product_id = product.id  
        // WHERE 
        // ORDER_DATE is not null
        // GROUP BY cart.fk_product_id 
        // ORDER BY quantity DESC;"

        return $this->createQueryBuilder('c') // c is the cart
            ->select('fkp.name as name, SUM(c.quantity) as quantity, fkp.picture as picture')
            ->innerJoin("c.fk_product", "fkp") // fkproductid it is only an alies  
            ->andWhere('c.order_date IS NOT NULL')
            ->groupBy('c.fk_product')
            ->orderBy('c.quantity', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getSalesGroupByUser(): array
    {
        //SELECT user.first_name as fname, user.last_name as lname, SUM(cart.quantity * cart.price) as total, user.picture as picture  
        // FROM cart 
        // INNER JOIN user ON cart.fk_user_id_id = user.id  
        // WHERE 
        // ORDER_DATE is not null
        // GROUP BY cart.fk_user_id_id 
        // ORDER BY total DESC;

        return $this->createQueryBuilder('c') // c is the cart
            ->select('usr.first_name as fname, usr.last_name as lname, SUM(c.quantity * c.price) as total, usr.picture as picture')
            ->innerJoin("c.fk_userID", "usr")   
            ->andWhere('c.order_date IS NOT NULL')
            ->groupBy('c.fk_userID')
            ->orderBy('total', 'DESC')
            ->getQuery()
            ->getResult();
    }


    public function getSalesGroupByOrderDate(): array
    {
        // SELECT ORDER_DATE, SUM(cart.quantity * cart.price) as total  
        // FROM cart   
        // WHERE 
        // ORDER_DATE is not null
        // GROUP BY ORDER_DATE
        // ORDER BY ORDER_DATE DESC;

        return $this->createQueryBuilder('c') // c is the cart
            ->select('c.order_date, SUM(c.quantity * c.price) as total')   
            ->andWhere('c.order_date IS NOT NULL')
            ->groupBy('c.order_date')
            ->orderBy('c.order_date', 'DESC', 'total', 'DESC')
            ->getQuery()
            ->getResult();
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
