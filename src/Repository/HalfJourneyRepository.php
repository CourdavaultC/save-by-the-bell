<?php

namespace App\Repository;

use App\Entity\HalfJourney;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HalfJourney|null find($id, $lockMode = null, $lockVersion = null)
 * @method HalfJourney|null findOneBy(array $criteria, array $orderBy = null)
 * @method HalfJourney[]    findAll()
 * @method HalfJourney[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HalfJourneyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HalfJourney::class);
    }

    // /**
    //  * @return HalfJourney[] Returns an array of HalfJourney objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HalfJourney
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
