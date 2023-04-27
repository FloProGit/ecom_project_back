<?php



namespace App\Controller;





use App\Entity\Product;
use App\Entity\ProductVariation;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\ProductVariationRepository;
use App\Repository\MediaUrlRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductVariationEditController extends AbstractController
{

    public function __construct(
        private CategoryRepository $categoryRepository,
        private ProductRepository $productRepository,
        private ProductVariationRepository $productVariationRepository,
        private MediaUrlRepository $mediaUrlRepository,
    )
    {
    }

    public function index(ProductVariation $productVariation ) : response
    {
        $product = $productVariation->getProductId();
        return $this->render('Pages/ProductVariation/product_variation_edit.html.twig',[
            'productId' => $product,
            'productsVariation' => $productVariation,
            'breadcrumbs'=>[
                ['route'=> 'products_list','data' => ['name' => 'Product']],
                ['route'=> 'product_edit','param' => ['id'=> $product->getId()],'data' => ['name' => $product->getName()]],
                ['data' => ['name' => 'Variation ' .$productVariation->getExtReference()]]
            ]
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
