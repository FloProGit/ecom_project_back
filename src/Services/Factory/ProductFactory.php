<?php declare(strict_types=1);

namespace App\Services\Factory;

use App\Entity\Product;
use App\Entity\ProductVariation;
use App\Services\Normalizer\ProductNormalizer;
use App\Services\Normalizer\ProductNormalizerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\Normalizer\ProductKeyNormalize;

final class ProductFactory {

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }
    public function buildProduct(ProductNormalizerInterface $productDataInterface, ProductVariation $productVariation = null): Product {

        $productData = (new ProductNormalizer($productDataInterface))->getNormalizeData();
        if(!isset($productVariation)) {
            $productVariation = (new ProductVariationFactory($this->entityManager))->buildProduct($productDataInterface);
        }
        $product = (new Product())
            ->setExtId($productData[ProductKeyNormalize::ID])
            ->setExtReference($productData[ProductKeyNormalize::EXT_REFERENCE] ?? ProductKeyNormalize::UNDEFINED_VALUE)
            ->setName($productData[ProductKeyNormalize::NAME] ?? ProductKeyNormalize::UNDEFINED_VALUE)
            ->setWidth(floatval($productData[ProductKeyNormalize::WIDTH]) ?? 0.0)
            ->setHeight(floatval($productData[ProductKeyNormalize::HEIGHT]) ?? 0.0)
            ->setDepth(floatval($productData[ProductKeyNormalize::DEPTH]) ?? 0.0)
            ->setWeight(floatval($productData[ProductKeyNormalize::WEIGHT]) ?? 0.0)
            ->setCreatedAt($productData[ProductKeyNormalize::CREATED_AT] ?? new \DateTimeImmutable(ProductKeyNormalize::DATE_NOW))
            ->setUpdatedAt($productData[ProductKeyNormalize::UPDATED_AT] ?? new \DateTimeImmutable(ProductKeyNormalize::DATE_NOW))
            ->setDescription($productData[ProductKeyNormalize::DESCRIPTION] ?? ProductKeyNormalize::UNDEFINED_VALUE)
            ->setShortDescription($productData[ProductKeyNormalize::SHORT_DESCRIPTION] ?? ProductKeyNormalize::UNDEFINED_VALUE)
            ->setHasVariation($productData[ProductKeyNormalize::HAS_VARIATION] ?? false)
            ->addMultipleCategory($productData[ProductKeyNormalize::CATEGORIES]??[])
            ->addProductVariation($productVariation);
        $this->entityManager->persist($productVariation);

        return $product;
    }


}
