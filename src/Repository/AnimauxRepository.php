<?php

namespace App\Repository;

use App\Entity\Animaux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Enclos;

/**
 * @extends ServiceEntityRepository<Animaux>
 */
class AnimauxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animaux::class);
    }
/*
public function countQuarantinedAnimalsInEnclosExcludingOne(Enclos $enclos, int $animalId){
    return $this->createQueryBuilder('a')
        ->select('COUNT(a.id)')
        ->where('a.enclos = :enclos')
        ->andWhere('a.EsEnQuarantaine = :quarantaine')
        ->andWhere('a.id != :animalId')
        ->setParameter('enclos', $enclos)
        ->setParameter('quarantaine', true)
        ->setParameter('animalId', $animalId)
        ->getQuery()
        ->getSingleScalarResult();
}
*/

    //    /**
    //     * @return Animaux[] Returns an array of Animaux objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Animaux
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
