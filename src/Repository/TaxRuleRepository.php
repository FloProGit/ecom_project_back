<?php

namespace App\Repository;

use App\Entity\TaxRule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TaxRule>
 *
 * @method TaxRule|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaxRule|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaxRule[]    findAll()
 * @method TaxRule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaxRuleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaxRule::class);
    }

    public function save(TaxRule $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TaxRule $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
