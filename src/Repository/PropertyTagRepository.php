<?php

namespace App\Repository;

use App\Entity\PropertyTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PropertyTag>
 *
 * @method PropertyTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method PropertyTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method PropertyTag[]    findAll()
 * @method PropertyTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyTagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PropertyTag::class);
    }

//    /**
//     * @return PropertyTag[] Returns an array of PropertyTag objects
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

//    public function findOneBySomeField($value): ?PropertyTag
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
