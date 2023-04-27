<?php declare(strict_types=1);

namespace App\Services\Normalizer\Product;

use App\Services\Normalizer\ProductNormalizerInterface;
use App\Services\Normalizer\ProductKeyNormalize;

final class ProductVariationNormaliserFromPrestaShop implements ProductNormalizerInterface
{

    public function __construct(private array $data){
    }

    public function NormalizeProduct(): array
    {
        return [
            ProductKeyNormalize::ID => $this->data["﻿PRODUCT_ID"],
            ProductKeyNormalize::EXT_REFERENCE => $this->data['REFERENCE'],
            ProductKeyNormalize::NAME => $this->data['NAME'],
            ProductKeyNormalize::QUANTITY => $this->data['QUANTITY'],
            ProductKeyNormalize::EAN13 => $this->data['EAN13'],
            ProductKeyNormalize::MINIMAL_QUANTITY => $this->data['MINIMAL_QUANTITY'],
            ProductKeyNormalize::PRICE_TAX_EXCLUDE => $this->data['PRICE_TAX_EXCLUDE'],
            ProductKeyNormalize::WHOLESALE_PRICE => $this->data['WHOLESALE_PRICE'],
            ProductKeyNormalize::MEDIA_URL => $this->data['IMAGE_URL'],
            ProductKeyNormalize::IS_MAIN => $this->data['IS_MAIN'],
            ProductKeyNormalize::MANUFACTER => $this->data['MANUFACTER'],
            ProductKeyNormalize::CONDITION => $this->data['CONDITION'],
            ProductKeyNormalize::ATTRIBUTE => $this->data['ATTRIBUTE'],
            ProductKeyNormalize::PRODUCT => $this->data['PRODUCT'],
        ];
    }
}
