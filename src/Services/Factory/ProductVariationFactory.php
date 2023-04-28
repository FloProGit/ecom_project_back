<?php declare(strict_types=1);

namespace App\Services\Factory;

use App\Entity\ProductVariation;
use App\Services\Normalizer\ProductNormalizer;
use App\Services\Normalizer\ProductNormalizerInterface;
use App\Services\Normalizer\ProductKeyNormalize;

final class ProductVariationFactory
{
    public function buildProduct(ProductNormalizerInterface $productDataInterface): ProductVariation
    {
        $productVariationData = (new ProductNormalizer($productDataInterface))->getNormalizeData();
        if(!is_array($productVariationData[ProductKeyNormalize::MEDIA_URL]))
        {
            dd($productVariationData[ProductKeyNormalize::MEDIA_URL]);
        }
        return  (new ProductVariation())
            ->setExtId($productVariationData[ProductKeyNormalize::ID] ?? ProductKeyNormalize::UNDEFINED_VALUE)
            ->setName($productVariationData[ProductKeyNormalize::NAME] ?? ProductKeyNormalize::UNDEFINED_VALUE)
            ->setQuantity(intval($productVariationData[ProductKeyNormalize::QUANTITY]) ?? 0)
            ->setMinimalQuantity(intval($productVariationData[ProductKeyNormalize::MINIMAL_QUANTITY]) ?? 0)
            ->setEan13($productVariationData[ProductKeyNormalize::EAN13] ?? ProductKeyNormalize::UNDEFINED_VALUE)
            ->setPriceTaxExclude(floatval($productVariationData[ProductKeyNormalize::PRICE_TAX_EXCLUDE]) ?? 0.0)
            ->setConditionProductId($productVariationData[ProductKeyNormalize::CONDITION] ?? null)
            ->setWholesalePrice(floatval($productVariationData[ProductKeyNormalize::WHOLESALE_PRICE]) ?? 0.0)
            ->setExtReference($productVariationData[ProductKeyNormalize::EXT_REFERENCE])
            ->setIsMain($productVariationData[ProductKeyNormalize::IS_MAIN] ?? false)
            ->addMultipleMediaUrl($productVariationData[ProductKeyNormalize::MEDIA_URL] ?? [])
            ->setAttribute($productVariationData[ProductKeyNormalize::ATTRIBUTE] ?? null)
            ->setManufacterId($productVariationData[ProductKeyNormalize::MANUFACTER])
            ->setCreatedAt($productVariationData[ProductKeyNormalize::CREATED_AT] ?? new \DateTimeImmutable(ProductKeyNormalize::DATE_NOW))
            ->setUpdatedAt($productVariationData[ProductKeyNormalize::UPDATED_AT] ?? new \DateTimeImmutable(ProductKeyNormalize::DATE_NOW))
            ->setOnSale(false)
            ;
    }


}
