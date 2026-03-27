<?php

namespace App\Repository;

use App\Entity\What;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<What>
 */
class WhatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, What::class);
    }

    public function findNotAssignedToUser(User $user): array
    {
        // return $this->createQueryBuilder('w')
        //     ->leftJoin('w.whatUsers', 'wu', 'WITH', 'wu.user = :user')
        //     ->where('wu.id IS NULL')
        //     ->setParameter('user', $user)
        //     ->getQuery()
        //     ->getResult();
        return $this->createQueryBuilder('w')
            ->where('w.id NOT IN (
                SELECT IDENTITY(wu.what)
                FROM App\Entity\WhatUser wu
                WHERE wu.user = :user
            )')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return What[] Returns an array of What objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('w.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?What
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
