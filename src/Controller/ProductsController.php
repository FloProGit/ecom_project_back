<?php



namespace App\Controller;





use App\Entity\Category;
use App\Entity\MediaUrl;
use App\Entity\Product;
use App\Entity\ProductVariation;
use App\Form\ProductType;
use App\Form\ProductVariationType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Filesystem\Filesystem;

use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
class ProductsController extends AbstractController
{
    public function __construct(private ProductRepository $productRepository,private EntityManagerInterface $entityManager)
    {

    }

    public function index() : response
    {
        $result = $this->productRepository->getProductsForList();
        return $this->render('Pages/Product/products.html.twig',[
            'products' => $result,'breadcrumbs'=>[
                ['data' => ['name' => 'Product']]
            ]]);
    }

    public function editProduct(Product $product,Request $request) : response
    {

        $form = $this->createForm(ProductType::class,$product);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            try {
                $product = $form->getData();
                $product->setUpdatedAt(new \DateTimeImmutable('now'));
                $this->entityManager->persist($product);
                $this->entityManager->flush();
            }
            catch (\Exception $e)
            {
                dd($e);
            }
        }
        $productVariation=null;
        if($product->isHasVariation()) {

            $productVariation = $this->entityManager->getRepository(ProductVariation::class)->getVariationForListFromProductID($product->getId());
        }

        $MediaUrlVariantArray = $this->entityManager->getRepository(MediaUrl::class)->getMainMediaUrlForVariantsFromProduct($product->getProductVariations()->toArray());

        $resultCategoryRequest =$this->entityManager->getRepository(Category::class)->getAllNameArray();
        $haystack=[2570,2580];
        $returnedArray = [];
        foreach ($resultCategoryRequest as $key=>$value)
        {
            $returnedArray[$key] = ['label'=>$value,'selected'=>in_array($key,$haystack)];
        }

        return $this->render('Pages/Product/product_edit.html.twig',[
            'breadcrumbs'=>[
                ['route'=> 'products_list','data' => ['name' => 'Categories']],
                ['data' => ['name' => $product->getName()]]
            ],
            'productsVariation' => $productVariation,
            'MediaUrlVariantArray' => $MediaUrlVariantArray,
            'hasVaration' => $product->isHasVariation(),
            'product_form'=> $form->createView(),
        ]);

    }
}