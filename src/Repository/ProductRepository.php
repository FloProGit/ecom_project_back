<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Product[] Returns an array of Product objects
//     */
    public function getProductsForList(): array
    {
        //PROBLEME AVEC DQL LIMIT ET OFFSET ajout de MediaUrl.is_main en bdd pour limité la sortie a 1 image

        $dql = 'SELECT p.id ,p.name , pv.ext_reference , med.url_link , man.ext_id , pv.quantity ,cp.current_condition , pv.is_main
         FROM App\Entity\MediaUrl med 
         JOIN med.product_variation pv
         JOIN pv.product p 
         JOIN App\Entity\Manufacter man WITH pv.manufacter = man.id
         JOIN App\Entity\ConditionProduct cp WITH pv.condition_product = cp.id 
         WHERE pv.is_main = true AND med.is_main = true';
        $query = $this->getEntityManager()->createQuery($dql);

        return  $query->execute();


    }


    public function getProductById(int $id):Array
    {
        //SQL "SELECT * FROM product p JOIN product_variation pv ON  p.id = pv.product_id WHERE p.id = 1"
        $dql = 'SELECT p 
        FROM App\Entity\Product p 
        WHERE p.id = :id ';

        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('id',$id);
        return  $query->execute();
    }

    public function getProductsByids(array $ids):Array
    {

       $arrayInIds = array_map(function ($id){
          return intval($id);
    },$ids);

        //SQL "SELECT * FROM product p JOIN product_variation pv ON  p.id = pv.product_id WHERE p.id = 1"
        $dql = 'SELECT p 
        FROM App\Entity\Product p 
        WHERE p.id IN (:ids)';

        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('ids',$ids);
        return  $query->execute();
    }
}
