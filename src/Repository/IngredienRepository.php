<?php

namespace App\Repository;

use App\Entity\Ingredien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ingredien>
 *
 * @method Ingredien|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ingredien|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ingredien[]    findAll()
 * @method Ingredien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredienRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ingredien::class);
    }

    //    /**
    //     * @return Ingredien[] Returns an array of Ingredien objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Ingredien
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
