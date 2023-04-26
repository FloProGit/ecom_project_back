<?php declare(strict_types=1);

namespace App\Services\Normalizer\Product;


final class ProductNormalizer {

    public function __construct(private ProductNormalizerInterface $Normalizer) {}

    public function getNormalizeData(): array{
        return $this->Normalizer->NormalizeProduct();
    }

}
