<?php

namespace App\Repository;

use App\Entity\MediaUrl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MediaUrl>
 *
 * @method MediaUrl|null find($id, $lockMode = null, $lockVersion = null)
 * @method MediaUrl|null findOneBy(array $criteria, array $orderBy = null)
 * @method MediaUrl[]    findAll()
 * @method MediaUrl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediaUrlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MediaUrl::class);
    }

    public function save(MediaUrl $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MediaUrl $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getMainMediaUrlForVariantsFromProduct(array $ArrayProductVariants):array
    {


        $Main_Variant = null;
        $arrayUrlsByVariant = [];
        foreach ($ArrayProductVariants as $variant)
        {

            if(!$Main_Variant)
            {
                $Main_Variant = $variant;
                continue;
            }
            $noMainUrl = true;
            foreach ($variant->getMediaUrls()->toArray() as $mediaUrl)
            {
                $noMainUrl = false;
                $arrayUrlsByVariant[$variant->getId()] = $mediaUrl->getUrlLink();
            }
            if($noMainUrl)
            {
                $arrayUrlsByVariant[$variant->getId()]= $Main_Variant->getMediaUrls()->toArray()[0]->getUrlLink();
            }
        }
        return $arrayUrlsByVariant;

    }

}
