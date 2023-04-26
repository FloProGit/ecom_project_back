<?php



namespace App\Controller;





use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\ProductVariationRepository;
use App\Repository\MediaUrlRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $pv = $this->productVariationRepository->getVariationForListFromProductID($product->getId());
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
                'hasVaration' => $product->isHasVariation()
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
