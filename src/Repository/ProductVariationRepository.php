<?php

namespace App\Repository;

use App\Entity\ProductVariation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductVariation>
 *
 * @method ProductVariation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductVariation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductVariation[]    findAll()
 * @method ProductVariation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductVariationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductVariation::class);
    }

    public function save(ProductVariation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ProductVariation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function getVariationForListFromProductID(int $id)
    {
        $dql = 'SELECT 
        pv.ext_reference ,
        pv.id ,
        pv.quantity ,
        p.id as product_id
         FROM App\Entity\Product p
         JOIN App\Entity\ProductVariation pv WITH  pv.product = p.id  
         WHERE p.id = :p_id';
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter("p_id",$id);
//        dd($query->execute());
        return  $query->execute();
    }
//    /**
//     * @return ProductVariation[] Returns an array of ProductVariation objects
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

//    public function findOneBySomeField($value): ?ProductVariation
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
