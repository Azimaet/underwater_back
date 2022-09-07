<?php

namespace App\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Entity\DivingEnvironment;

/**
 * @extends ServiceEntityRepository<DivingEnvironment>
 *
 * @method DivingEnvironment|null find($id, $lockMode = null, $lockVersion = null)
 * @method DivingEnvironment|null findOneBy(array $criteria, array $orderBy = null)
 * @method DivingEnvironment[]    findAll()
 * @method DivingEnvironment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DivingEnvironmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DivingEnvironment::class);
    }

    public function add(DivingEnvironment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DivingEnvironment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return DivingEnvironment[] Returns an array of DivingEnvironment objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?DivingEnvironment
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
