<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 *
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function save(Category $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Category $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getCategoriesByCodes(string $codes): array
    {
        $codes = explode(',',$codes);
        $Intcodes =  array_map(function(string $code){
            return intval($code);
        },$codes);

        $dql = 'SELECT cat FROM App\Entity\Category cat WHERE cat.code IN (:array_codes)';
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter("array_codes",$Intcodes);
        return  $query->execute();
    }


    public function getAllNameArray(): array
    {
        $resultCategoryRequest = $this->findAll();
        $arrayName =[];
        foreach ($resultCategoryRequest as $category)
        {
            $arrayName[$category->getCode()]= $category->getName();
        }

        return $arrayName;
    }

}
