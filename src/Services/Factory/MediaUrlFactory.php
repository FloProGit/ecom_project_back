<?php declare(strict_types=1);

namespace App\Services\Factory;

use App\Entity\MediaUrl;

final class MediaUrlFactory
{
    public function buildMediaUrl(string $name, string $urlPath,bool $isMain = false): MediaUrl
    {
        $fileExtension = pathinfo($urlPath, PATHINFO_EXTENSION);

        return (new MediaUrl())
            ->setMimeType("image/" . $fileExtension)
            ->setName($name)
            ->setUrlLink($urlPath)
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setIsMain($isMain);
    }
}
