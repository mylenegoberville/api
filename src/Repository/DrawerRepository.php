<?php

namespace App\Repository;

use App\Entity\Drawer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Drawer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Drawer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Drawer[]    findAll()
 * @method Drawer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DrawerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Drawer::class);
    }

    // /**
    //  * @return Drawer[] Returns an array of Drawer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Drawer
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
