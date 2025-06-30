<?php

namespace App\Repository;

use App\Entity\PlanNettoyage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
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

    public function findPlansWithLastNettoyageAndReccurence(): array
    {
        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.reccurence', 'r')
            ->addSelect('r')
            ->leftJoin('p.nettoyageEffectues', 'n')
            ->addSelect('MAX(n.date) AS lastNettoyageDate')
            ->groupBy('p.id')
            ->addGroupBy('r.id'); // Ajout si Doctrine le réclame

        return $qb->getQuery()->getResult();
    }
    
}
