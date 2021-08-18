<?php

namespace App\Repository;

use App\Entity\Dealer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Dealer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dealer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dealer[]    findAll()
 * @method Dealer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DealerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dealer::class);
    }

    // /**
    //  * @return Dealer[] Returns an array of Dealer objects
    //  */

    public function findArray()
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.disabled = :disabled')
            ->setParameter('disabled', false)
            ->orderBy('d.priority', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getArrayResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Dealer
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
