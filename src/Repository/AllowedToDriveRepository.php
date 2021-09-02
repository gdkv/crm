<?php

namespace App\Repository;

use App\Entity\Credit\AllowedToDrive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AllowedToDrive|null find($id, $lockMode = null, $lockVersion = null)
 * @method AllowedToDrive|null findOneBy(array $criteria, array $orderBy = null)
 * @method AllowedToDrive[]    findAll()
 * @method AllowedToDrive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AllowedToDriveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AllowedToDrive::class);
    }

}
