<?php declare(strict_types=1);

namespace App\Services\Factory;

use App\Entity\MediaUrl;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class MultiMediaUrlFactory
{
    private MediaUrlFactory $mediaUrlFactory;
    private EntityManagerInterface $entityManager;
    public function __construct(MediaUrlFactory $mediaUrlFactory,EntityManagerInterface $entityManager)
    {
        $this->mediaUrlFactory = $mediaUrlFactory;
        $this->entityManager = $entityManager;
    }

    public function buildMediaUrls(array $images,string $path): array
    {
        $arrayMediaUrls =[];
        $isMain = true;
        //image add
        foreach ($images as $image) {
            $fichier = md5(uniqid()) . '.' . $image->guessExtension();
            $image->move(
                $path,
                $fichier
            );
            $Media = $this->mediaUrlFactory->buildMediaUrl($image->getClientOriginalName(),$fichier,$isMain);
            $isMain=false;
            $this->entityManager->persist($Media);
            $arrayMediaUrls[] =$Media;
        }
        return $arrayMediaUrls;
    }
}
