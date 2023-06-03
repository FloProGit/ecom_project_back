<?php declare(strict_types=1);

namespace App\Services\Infrastructure;

use App\Services\Factory\MediaUrlFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final class MediaUrlDownloadService {
    private string $imageDirectory;
    private EntityManagerInterface $entityManager;
    private MediaUrlFactory $mediaUrlFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        ParameterBagInterface $parameterBag,
        MediaUrlFactory $mediaUrlFactory,
    ){
        $this->imageDirectory = $parameterBag->get('images_directory');
        $this->entityManager = $entityManager;
        $this->mediaUrlFactory = $mediaUrlFactory;
    }

    public function downloadImagesAndSaveMediaUrl(array $urls,bool $setFirstIsMain = false): array {

        return array_filter( array_map(function(string $url) use(&$setFirstIsMain) {

            if('' === $url)
            {
                return null;
            }

            $fileName = $this->downloadImageAndGetName($url);

            if(null === $fileName)
            {
                return null;
            }
            $name = pathinfo($url, PATHINFO_FILENAME);
            $mediaUrl = $this->mediaUrlFactory->buildMediaUrl($name,$fileName);
            $mediaUrl->setIsMain($setFirstIsMain);
            $setFirstIsMain = false;
            $this->entityManager->persist($mediaUrl);

            return $mediaUrl;
        }, $urls), function($MediaUrl) {
            return $MediaUrl !== null ;
        });
    }

    private function downloadImageAndGetName(string $url): ?string {

        try {
            $url =  str_replace(' ','%20',$url);
            $imageContent = file_get_contents($url);
            if(!$imageContent) {
                return null;
            }

            $b64 = base64_encode( $imageContent);

            // '/' : jpg
            // 'i' : png
            // 'R' : gif
            // 'U' : webp
            $fileExtension = '';
            switch ($b64[0])
            {
                case '/':$fileExtension = 'jpg';break;
                case 'i':$fileExtension = 'png';break;
                case 'R':$fileExtension = 'gif';break;
                case 'U':$fileExtension = 'webp';break;
            }
//            if($fileExtension == '')
//            {
//                $fileExtension = pathinfo($url, PATHINFO_EXTENSION);
//            }

            if(is_array($fileExtension) || '' === $fileExtension)
            {
                return null;
            }

            $fileName = sha1(uniqid()) . '.' .$fileExtension;
            file_put_contents($this->imageDirectory . DIRECTORY_SEPARATOR  . $fileName, $imageContent);

            return $fileName;
        }
        catch(\Exception $e)
        {
            return null;
        }

    }
}
