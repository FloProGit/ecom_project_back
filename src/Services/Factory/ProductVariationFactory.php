<?php declare(strict_types=1);

namespace App\Services\Factory;

use App\Entity\ConditionProduct;
use App\Entity\Product;
use App\Entity\ProductVariation;
use App\Services\Normalizer\ProductNormalizer;
use App\Services\Normalizer\ProductNormalizerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\Normalizer\ProductKeyNormalize;

final class ProductVariationFactory
{

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }


    public function buildProduct(ProductNormalizerInterface $productDataInterface): ProductVariation
    {
        $productVariationData = (new ProductNormalizer($productDataInterface))->getNormalizeData();

        $productVariation = (new ProductVariation())
            ->setExtId($productVariationData[ProductKeyNormalize::ID] ?? ProductKeyNormalize::UNDEFINED_VALUE)
            ->setName($productVariationData[ProductKeyNormalize::NAME] ?? ProductKeyNormalize::UNDEFINED_VALUE)
            ->setQuantity(intval($productVariationData[ProductKeyNormalize::QUANTITY]) ?? 0)
            ->setMinimalQuantity(intval($productVariationData[ProductKeyNormalize::MINIMAL_QUANTITY]) ?? 0)
            ->setEan13($productVariationData[ProductKeyNormalize::EAN13] ?? ProductKeyNormalize::UNDEFINED_VALUE)
            ->setMinimalQuantity(intval($productVariationData[ProductKeyNormalize::MINIMAL_QUANTITY]) ?? 0)
            ->setPriceTaxExclude(floatval($productVariationData[ProductKeyNormalize::PRICE_TAX_EXCLUDE]) ?? 0.0)
            ->setOnSale(false)
            ->setConditionProductId($productVariationData[ProductKeyNormalize::CONDITION] ?? null)
            ->setWholesalePrice(floatval($productVariationData[ProductKeyNormalize::WHOLESALE_PRICE]) ?? 0.0)
            ->setCreatedAt($productVariationData[ProductKeyNormalize::CREATED_AT] ?? new \DateTimeImmutable(ProductKeyNormalize::DATE_NOW))
            ->setUpdatedAt($productVariationData[ProductKeyNormalize::UPDATED_AT] ?? new \DateTimeImmutable(ProductKeyNormalize::DATE_NOW))
            ->setExtReference($productVariationData[ProductKeyNormalize::EXT_REFERENCE])
            ->setIsMain($productVariationData[ProductKeyNormalize::IS_MAIN] ?? false)
            ->addMultipleMediaUrl($productVariationData[ProductKeyNormalize::MEDIA_URL] ?? [])
            ->setAttribute($productVariationData[ProductKeyNormalize::ATTRIBUTE] ?? null)
            ->setManufacterId($productVariationData[ProductKeyNormalize::MANUFACTER]);

        if(isset($productVariationData[ProductKeyNormalize::PRODUCT]))
        {
            $product = $productVariationData[ProductKeyNormalize::PRODUCT];
            $product->setHasVariation(true);
            $product->addProductVariation($productVariation);
            $this->entityManager->persist($product);
        }

            $this->entityManager->persist($productVariation);
        return $productVariation;
    }


}
