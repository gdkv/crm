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


    public function findFiltered($filters = [], $orders = [], $limit = 0)
    {
        $query = $this->createQueryBuilder('a');

        $query->leftJoin('a.client', 'cl');
        $query->leftJoin('a.car', 'cr');

        $query
            ->andWhere("a.actionAt >= :dateStart")
            ->setParameter("dateStart", $filters['date']->format("Y-m-d 00:00:00"))
            ->andWhere("a.actionAt <= :dateFinish")
            ->setParameter("dateFinish", $filters['date']->format("Y-m-d 23:59:59"));
    
        unset($filters['date']);

        foreach ($filters as $key => $value) {

            $field = match ($key) {
                "operator" => "a.operator",
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

        return $query->getQuery()->getResult();
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
