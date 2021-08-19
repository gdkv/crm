<?php

namespace App\Repository;

use App\Entity\Application\Application;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Application|null find($id, $lockMode = null, $lockVersion = null)
 * @method Application|null findOneBy(array $criteria, array $orderBy = null)
 * @method Application[]    findAll()
 * @method Application[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApplicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Application::class);
    }


    public function findFilteredArray($filters = [], $orders = [], $limit = 0)
    {
        $query = $this->createQueryBuilder('a');

        $query->leftJoin('a.client', 'cl');
        $query->leftJoin('a.car', 'cr');

        foreach ($filters as $key => $value) {

            $field = match ($key) {
                "operator" => "a.operator",
                "date" => "a.actionAt",
                "client" => "cl.name",
                "phone" => "cl.phone",
                "car" => "cr.brand",
            };

            $query
                ->andWhere("{$field} = :{$key}")
                ->setParameter($key, $value);
        }

        $query->addOrderBy('a.pushedAt', 'DESC');
        
        if ($limit > 0 ) {
            $query->setMaxResults($limit);
        }

        return $query->getQuery()->getArrayResult();

    }

    /*
    public function findOneBySomeField($value): ?Application
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
