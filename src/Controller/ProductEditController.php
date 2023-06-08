<?php


namespace App\Controller;


use App\Entity\Product;
use App\Form\ProductType;
use App\Form\ProductVariationType;
use App\Repository\CategoryRepository;
use App\Repository\ProductVariationRepository;
use App\Repository\MediaUrlRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProductEditController extends AbstractController
{
    private CategoryRepository $categoryRepository;
    private ProductVariationRepository $productVariationRepository;
    private MediaUrlRepository $mediaUrlRepository;
    private TranslatorInterface $t;

    public function __construct(
        CategoryRepository         $categoryRepository,
        ProductVariationRepository $productVariationRepository,
        MediaUrlRepository         $mediaUrlRepository,
        EntityManagerInterface     $entityManager,
        TranslatorInterface        $t
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->productVariationRepository = $productVariationRepository;
        $this->mediaUrlRepository = $mediaUrlRepository;
        $this->entityManager = $entityManager;
        $this->t = $t;
    }

    public function index(Product $product): response
    {
        if ($product->isHasVariation()) {
            $pv = $this->productVariationRepository->getVariationForListFromProductID($product->getId());
        } else {
            $pv = $product->getProductVariations()[0];
        }
        $MediaUrlVariantArray = $this->mediaUrlRepository->getMainMediaUrlForVariantsFromProduct($product->getProductVariations()->toArray());

        $resultCategoryRequest = $this->categoryRepository->getAllNameArray();
        $haystack = [2570, 2580];
        $returnedArray = [];
        foreach ($resultCategoryRequest as $key => $value) {
            $returnedArray[$key] = ['label' => $value, 'selected' => in_array($key, $haystack)];
        }
        return $this->render('Pages/Product/product_edit.html.twig',
            [
                'arrayTest' => json_encode($returnedArray),
                'selectedValues' => json_encode([2570, 2580]),
                'product' => $product,
                'productsVariant' => $pv,
                'MediaUrlVariantArray' => $MediaUrlVariantArray,
                'hasVaration' => $product->isHasVariation(),
                'breadcrumbs' => [
                    ['route' => 'products_list', 'data' => ['name' => 'Product']],
                    ['data' => ['name' => $product->getName()]]
                ]
                ,'navbardata' => json_encode(['fm'=> 'catalogue','sm'=>'products'])
            ]);
    }

    public function editProduct(Product $product, Request $request): response
    {

        $productForm = $this->createForm(ProductType::class, $product);

        $productForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid()) {
            try {
                $productVariation = $productForm->getData();
                $productVariation->setUpdatedAt(new \DateTimeImmutable('now'));
                $this->entityManager->persist($productVariation);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                dd($e);
            }
        }
        if ($product->isHasVariation()) {

            $pv = $this->productVariationRepository->getVariationForListFromProductID($product->getId());
        } else {
            $variationForm = $this->createForm(ProductVariationType::class, $product->getProductVariations()[0]);
            $variationForm->handleRequest($request);


        }
        $MediaUrlVariantArray = $this->mediaUrlRepository->getMainMediaUrlForVariantsFromProduct($product->getProductVariations()->toArray());

        $resultCategoryRequest = $this->categoryRepository->getAllNameArray();
        $haystack = [2570, 2580];
        $returnedArray = [];
        foreach ($resultCategoryRequest as $key => $value) {
            $returnedArray[$key] = ['label' => $value, 'selected' => in_array($key, $haystack)];
        }
        return $this->render('Pages/Product/product_edit.html.twig',
            [
                'arrayTest' => json_encode($returnedArray),
                'selectedValues' => json_encode([2570, 2580]),
                'product' => $product,
                'productsVariant' => $pv,
                'MediaUrlVariantArray' => $MediaUrlVariantArray,
                'hasVaration' => $product->isHasVariation(),
                'breadcrumbs' => [
                    ['route' => 'products_list', 'data' => ['name' => 'Product']],
                    ['data' => ['name' => $product->getName()]]
                ],
                'variation_form' => $variationForm->createView(),
                'navbardata' => json_encode(['fm'=> 'catalogue','sm'=>'products'])
            ]);
    }
}

