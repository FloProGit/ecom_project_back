<?php declare(strict_types=1);

namespace App\Services\Normalizer;


use App\Services\Normalizer\ProductNormalizerInterface;

final class ProductNormalizer {

    public function __construct(private ProductNormalizerInterface $Normalizer) {}

    public function getNormalizeData(): array{
        return $this->Normalizer->NormalizeProduct();
    }

}
