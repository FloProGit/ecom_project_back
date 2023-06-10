<?php

namespace App\Repository;

use App\Entity\ConditionProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConditionProduct>
 *
 * @method ConditionProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConditionProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConditionProduct[]    findAll()
 * @method ConditionProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConditionProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConditionProduct::class);
    }

    public function save(ConditionProduct $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ConditionProduct $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


}
