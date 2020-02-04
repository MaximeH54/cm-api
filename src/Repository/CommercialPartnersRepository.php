<?php

namespace App\Repository;

use App\Entity\CommercialPartners;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CommercialPartners|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommercialPartners|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommercialPartners[]    findAll()
 * @method CommercialPartners[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommercialPartnersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommercialPartners::class);
    }

    // /**
    //  * @return CommercialPartners[] Returns an array of CommercialPartners objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CommercialPartners
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
