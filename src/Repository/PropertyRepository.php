<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\PropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Migrations\Query\Query;
use Doctrine\ORM\Query as ORMQuery;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Property>
 *
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    /**
     * @param PropertySearch $search
     * @return ORMQuery
     */
    public function findAllVisibleQuery(PropertySearch $search): ORMQuery{
        $query =  $this->createQueryBuilder('p')
            ->where('p.sold = false');
        
        if ($search->getMaxPrice()){
            $query = $query
                ->andWhere('p.price < :maxPrice')
                ->setParameter('maxPrice', $search->getMaxPrice())
                ;
        }
        if ($search->getMinSurface()){
            $query = $query
                ->andWhere('p.surface < :minSurface')
                ->setParameter('minSurface', $search->getMinSurface())
                ;
        }

        // if we got 1 or more options in GET parameters
        if($search->getOptions()->count() > 0){
            $k = 0;
            foreach ($search->getOptions() as $option) {
                $k++;
                $query = $query
                    ->andWhere(":option$k MEMBER OF p.options")
                    ->setParameter("option$k", $option)
                    ;
            }
        }

        return $query->getQuery();
    }

    /**
     * @return Property[]
     */
    public function findLatest(): array{
        return $this->createQueryBuilder('p')
            ->where('p.sold = false')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(7)
            ->getQuery()
            ->getResult()
        ;
    }


//    /**
//     * @return Property[] Returns an array of Property objects
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

//    public function findOneBySomeField($value): ?Property
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
