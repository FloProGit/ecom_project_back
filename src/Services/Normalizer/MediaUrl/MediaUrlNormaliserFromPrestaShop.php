<?php declare(strict_types=1);

namespace App\Services\Normalizer\MediaUrl;

use App\Services\Normalizer\ProductNormalizerInterface;
use App\Services\Normalizer\ProductKeyNormalize;

final class MediaUrlNormaliserFromPrestaShop implements ProductNormalizerInterface
{

    public function __construct( private array $data){
    }

    public function NormalizeProduct(): array
    {
        return [
            ProductKeyNormalize::ID => $this->data["﻿ID"],
            ProductKeyNormalize::WIDTH => $this->data['WIDTH'],
            ProductKeyNormalize::EXT_REFERENCE => $this->data['bb_REFERENCE'],
            ProductKeyNormalize::NAME => $this->data['NAME'],
            ProductKeyNormalize::HEIGHT => $this->data['HEIGHT'],
            ProductKeyNormalize::DEPTH => $this->data['DEPTH'],
            ProductKeyNormalize::WEIGHT => $this->data['WEIGHT'],
            ProductKeyNormalize::DESCRIPTION => $this->data['DESCRIPTION'],
            ProductKeyNormalize::SHORT_DESCRIPTION => $this->data['SHORT_DESCRIPTION'],
            ProductKeyNormalize::CATEGORIES => $this->data['CATEGORIES'],
            ProductKeyNormalize::QUANTITY => $this->data['QUANTITY'],
            ProductKeyNormalize::EAN13 => $this->data['EAN13'],
            ProductKeyNormalize::MINIMAL_QUANTITY => $this->data['MINIMAL_QUANTITY'],
            ProductKeyNormalize::PRICE_TAX_EXCLUDE => $this->data['PRICE_TAX_EXCLUDE'],
            ProductKeyNormalize::WHOLESALE_PRICE => $this->data['WHOLESALE_PRICE'],
            ProductKeyNormalize::MEDIA_URL => $this->data['IMAGES_URL'],
            ProductKeyNormalize::IS_MAIN => $this->data['IS_MAIN'],
            ProductKeyNormalize::MANUFACTER => $this->data['MANUFACTER'],
            ProductKeyNormalize::CONDITION => $this->data['CONDITION'],

        ];
    }
}
