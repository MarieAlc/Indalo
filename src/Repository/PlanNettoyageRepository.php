<?php

namespace App\Repository;

use App\Entity\PlanNettoyage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PlanNettoyage>
 */
class PlanNettoyageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlanNettoyage::class);
    }

    public function findTachesAValider(\DateTimeImmutable $aujourdHui): array
{
    $qb = $this->createQueryBuilder('p')
        ->leftJoin('p.reccurence', 'r')
        ->leftJoin('p.nettoyageEffectues', 'n')
        ->addSelect('r')
        ->addSelect('n')
        ->groupBy('p.id')
        ->having(
            'MAX(n.date) IS NULL OR DATE_ADD(MAX(n.date), INTERVAL r.intervalleJour DAY) <= :aujourdhui'
        )
        ->setParameter('aujourdhui', $aujourdHui);

    return $qb->getQuery()->getResult();
}

    //    /**
    //     * @return PlanNettoyage[] Returns an array of PlanNettoyage objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PlanNettoyage
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
