<?php

namespace App\Repository;

use App\Entity\Participantes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Participantes>
 *
 * @method Participantes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participantes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participantes[]    findAll()
 * @method Participantes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipantesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Participantes::class);
    }

//    /**
//     * @return Participantes[] Returns an array of Participantes objects
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

//    public function findOneBySomeField($value): ?Participantes
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
