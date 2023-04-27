<?php



namespace App\Controller;





use App\Entity\Product;
use App\Form\ProductType;
use App\Form\ProductVariationType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\ProductVariationRepository;
use App\Repository\MediaUrlRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductEditController extends AbstractController
{

    public function __construct(
        private CategoryRepository $categoryRepository,
        private ProductRepository $productRepository,
        private ProductVariationRepository $productVariationRepository,
        private MediaUrlRepository $mediaUrlRepository,
    )
    {
    }

    public function index(Product $product) : response
    {
        if($product->isHasVariation()) {
            $pv = $this->productVariationRepository->getVariationForListFromProductID($product->getId());
        }
        else{
            $pv = $product->getProductVariations()[0];
        }
        $MediaUrlVariantArray = $this->mediaUrlRepository->getMainMediaUrlForVariantsFromProduct($product->getProductVariations()->toArray());

        $resultCategoryRequest =$this->categoryRepository->getAllNameArray();
        $haystack=[2570,2580];
        $returnedArray = [];
        foreach ($resultCategoryRequest as $key=>$value)
        {
            $returnedArray[$key] = ['label'=>$value,'selected'=>in_array($key,$haystack)];
        }
        return $this->render('Pages/Product/product_edit.html.twig',
            [
                'arrayTest'=> json_encode($returnedArray),
                'selectedValues' => json_encode([2570,2580]),
                'product' => $product,
                'productsVariant' => $pv,
                'MediaUrlVariantArray' => $MediaUrlVariantArray,
                'hasVaration' => $product->isHasVariation(),
                'breadcrumbs'=>[
                    ['route'=> 'products_list','data' => ['name' => 'Product']],
                    ['data' => ['name' => $product->getName()]]
                ]
            ]);
    }

    public function editProduct(Product $product ,Request $request) : response
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
        if($product->isHasVariation()) {

            $pv = $this->productVariationRepository->getVariationForListFromProductID($product->getId());
        }
        else{
            $variationForm = $this->createForm(ProductVariationType::class, $product->getProductVariations()[0]);
            $variationForm->handleRequest($request);


        }
        $MediaUrlVariantArray = $this->mediaUrlRepository->getMainMediaUrlForVariantsFromProduct($product->getProductVariations()->toArray());

        $resultCategoryRequest =$this->categoryRepository->getAllNameArray();
        $haystack=[2570,2580];
        $returnedArray = [];
        foreach ($resultCategoryRequest as $key=>$value)
        {
            $returnedArray[$key] = ['label'=>$value,'selected'=>in_array($key,$haystack)];
        }
        return $this->render('Pages/Product/product_edit.html.twig',
            [
                'arrayTest'=> json_encode($returnedArray),
                'selectedValues' => json_encode([2570,2580]),
                'product' => $product,
                'productsVariant' => $pv,
                'MediaUrlVariantArray' => $MediaUrlVariantArray,
                'hasVaration' => $product->isHasVariation(),
                'breadcrumbs'=>[
                    ['route'=> 'products_list','data' => ['name' => 'Product']],
                    ['data' => ['name' => $product->getName()]]
                ],
                'variation_form'=> $variationForm->createView(),
            ]);
    }
}
//{
//    "2570": "Mode Accessoires",
//    "2573": "Vêtements et Chaussures",
//    "2575": "Sous-vêtements",
//    "2577": "Pyjamas et couvertures avec manches",
//    "2580": "Autres vêtements",
//    "2582": "Autres accessoires pour les chaussures",
//    "2584": "Accessoires",
//}
