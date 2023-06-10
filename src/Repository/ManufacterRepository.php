<?php

namespace App\Repository;

use App\Entity\Manufacter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Manufacter>
 *
 * @method Manufacter|null find($id, $lockMode = null, $lockVersion = null)
 * @method Manufacter|null findOneBy(array $criteria, array $orderBy = null)
 * @method Manufacter[]    findAll()
 * @method Manufacter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ManufacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Manufacter::class);
    }

    public function save(Manufacter $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Manufacter $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


}
