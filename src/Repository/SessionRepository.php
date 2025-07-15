<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Session>
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

//    /**
//     * @return Session[] Returns an array of Session objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Session
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function findSessionsAValider(): array
{
    return $this->createQueryBuilder('s')
        ->leftJoin('s.inscriptions', 'i')
        ->addSelect('i')
        ->where('s.date >= :now')
        ->setParameter('now', new \DateTime())
        ->getQuery()
        ->getResult();
}

public function findSessionsPourAnnulation(): array
{
    $limite = new \DateTime('+15 days');

    return $this->createQueryBuilder('s')
        ->leftJoin('s.inscriptions', 'i')
        ->addSelect('i')
        ->where('s.date <= :limite')
        ->andWhere('s.etat != :etat')
        ->setParameter('limite', $limite)
        ->setParameter('etat', 'Annulée')
        ->getQuery()
        ->getResult();
}


}
