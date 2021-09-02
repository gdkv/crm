<?php

namespace App\Repository;

use App\Entity\Credit\CreditForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CreditForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method CreditForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method CreditForm[]    findAll()
 * @method CreditForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreditFormRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CreditForm::class);
    }

}
