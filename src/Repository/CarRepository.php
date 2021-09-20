<?php

namespace App\Repository;

use App\Entity\Application\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    /**
     * @return Car[] Returns an array of Car objects
     */
    public function findDistinctBrands(array $filters = [])
    {
        $type = 'c.brand';

        if (count($filters)){
            if($filters['type'] === 'models') {
                $type = 'c.model';
            }
        }

        $query = $this->createQueryBuilder('c')
            ->select($type)
            ->orderBy($type, 'ASC')
            ->groupBy($type);

        if (count($filters)){
            if($filters['type'] === 'models') {
                $query
                    ->andWhere("c.brand LIKE :brand")
                    ->setParameter('brand', $filters['brand']);
            }
        }

        return $query->getQuery()->getResult();
    }

}
