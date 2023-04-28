<?php



namespace App\Controller;





use App\Entity\Product;
use App\Entity\ProductVariation;
use App\Form\ProductVariationType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\ProductVariationRepository;
use App\Repository\MediaUrlRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductVariationController extends AbstractController
{

    public function __construct(
        private CategoryRepository $categoryRepository,
        private ProductRepository $productRepository,
        private ProductVariationRepository $productVariationRepository,
        private MediaUrlRepository $mediaUrlRepository,
        private EntityManagerInterface $entityManager,
    ){}


//    public function index(ProductVariation $productVariation ) : response
//    {
//        $product = $productVariation->getProductId();
//        return $this->render('Pages/ProductVariation/product_variation_edit.html.twig',[
//            'productId' => $product,
//            'productsVariation' => $productVariation,
//            'breadcrumbs'=>[
//                ['route'=> 'products_list','data' => ['name' => 'Product']],
//                ['route'=> 'product_edit','param' => ['id'=> $product->getId()],'data' => ['name' => $product->getName()]],
//                ['data' => ['name' => 'Variation ' .$productVariation->getExtReference()]]
//            ]
//        ]);
//    }

    public function editProductVariation(ProductVariation $productVariation ,Request $request) : response
    {

        $form = $this->createForm(ProductVariationType::class,$productVariation);
        $product = $productVariation->getProductId();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            try {
                $productVariation = $form->getData();
                dd($form->get('images')->getData());
                $productVariation->setUpdatedAt(new \DateTimeImmutable('now'));
                $this->entityManager->persist($productVariation);
                $this->entityManager->flush();
            }
            catch (\Exception $e)
            {
                dd($e);
            }
        }

        return $this->render('Pages/ProductVariation/product_variation_edit.html.twig',[
            'breadcrumbs'=>[
                ['route'=> 'products_list','data' => ['name' => 'Categories']],
                ['route'=> 'product_edit','param' => ['id'=> $product->getId()],'data' => ['name' => $product->getName()]],
                ['data' => ['name' => 'Variation ' .$productVariation->getExtReference()]]
            ],
            'variation_form'=> $form->createView(),
        ]);

    }

    public function createProductVariation(Request $request) : response
    {
        $productVariation = new ProductVariation();
        $form = $this->createForm(ProductVariationType::class,$productVariation);
        $product = $productVariation->getProductId();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            try {
                $productVariation = $form->getData();
                $productVariation->setUpdatedAt(new \DateTimeImmutable('now'));
                $this->entityManager->persist($productVariation);
                $this->entityManager->flush();
            }
            catch (\Exception $e)
            {
                dd($e);
            }
        }
        return $this->render('Pages/ProductVariation/product_variation_edit.html.twig',[
            'breadcrumbs'=>[
                ['route'=> 'products_list','data' => ['name' => 'Categories']],
                ['route'=> 'product_edit','param' => ['id'=> $product->getId()],'data' => ['name' => $product->getName()]],
                ['data' => ['name' => 'Variation ' .$productVariation->getExtReference()]]
            ],
            'variation_form'=> $form->createView(),
        ]);

    }
}

