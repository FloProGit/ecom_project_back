<?php declare(strict_types=1);

namespace App\Services\Normalizer\ProductVariation;

use App\Services\Normalizer\ProductNormalizerInterface;
use App\Services\Normalizer\ProductKeyNormalize;

final class ProductVariationNormaliserFromPrestaShop implements ProductNormalizerInterface
{

    public function __construct(private array $data){
    }

    public function NormalizeProduct(): array
    {
        return [
            ProductKeyNormalize::ID => $this->data["﻿PRODUCT_ID"]??null,
            ProductKeyNormalize::EXT_REFERENCE => $this->data['REFERENCE']??null,
            ProductKeyNormalize::NAME => $this->data['NAME']??null,
            ProductKeyNormalize::QUANTITY => $this->data['QUANTITY']??null,
            ProductKeyNormalize::EAN13 => $this->data['EAN13']??null,
            ProductKeyNormalize::MINIMAL_QUANTITY => $this->data['MINIMAL_QUANTITY']??null,
            ProductKeyNormalize::PRICE_TAX_EXCLUDE => $this->data['PRICE_TAX_EXCLUDE']??null,
            ProductKeyNormalize::WHOLESALE_PRICE => $this->data['WHOLESALE_PRICE']??null,
            ProductKeyNormalize::MEDIA_URL => $this->data['IMAGE_URL']??null,
            ProductKeyNormalize::IS_MAIN => $this->data['IS_MAIN']??null,
            ProductKeyNormalize::MANUFACTER => $this->data['MANUFACTER']??null,
            ProductKeyNormalize::CONDITION => $this->data['CONDITION']??null,
            ProductKeyNormalize::ATTRIBUTE => $this->data['ATTRIBUTE']??null,
        ];
    }
}
