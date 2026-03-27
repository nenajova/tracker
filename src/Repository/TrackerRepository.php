<?php

namespace App\Repository;

use App\Entity\Tracker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;

/**
 * @extends ServiceEntityRepository<Tracker>
 */
class TrackerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tracker::class);
    }

    public function findByUser(User $user): array
    {
        return $this->createQueryBuilder('t')
            ->where('t.User = :user')
            ->setParameter('user', $user)
            ->orderBy('t.time', 'DESC')
            ->getQuery()
            ->getResult();
        // return $this->createQueryBuilder('w')
        //     ->where('w.id NOT IN (
        //         SELECT IDENTITY(wu.what)
        //         FROM App\Entity\WhatUser wu
        //         WHERE wu.user = :user
        //     )')
        //     ->setParameter('user', $user)
        //     ->getQuery()
        //     ->getResult();
    }

    //    /**
    //     * @return Tracker[] Returns an array of Tracker objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Tracker
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
