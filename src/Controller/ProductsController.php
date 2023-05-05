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
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
        $resultCategoryRequest =$this->entityManager->getRepository(Category::class)->getAllNameArray();
       $categoriesProduct = $product->getCategories()->ToArray();
        $codesCat =  array_map(function (Category $category) {
           return $category->getCode();
       },$categoriesProduct);
        $haystack=$codesCat;

        $returnedArray = [];
        foreach ($resultCategoryRequest as $key=>$value)
        {

            $returnedArray[$key] = ['label'=>$value,'selected'=>in_array($key,$haystack)];
        }
        if($form->isSubmitted() && $form->isValid())
        {
//            dd();
            try {
                $product = $form->getData();
//                $form->get('productVariations')[0]->get('images')
               $images = $form->get('productVariations')[0]->get('images')->getData();

               // TODO : Tu appelle MediaUrlSevrice retourne un tableau de MediaUrl

                foreach ($images as $image)
                {
                    $fichier = md5(uniqid()).'.'.$image->guessExtension();
                    $mimeType = $image->getMimeType();
                    $image->move(
                        $this->getParameter('images_directory').'/images',
                        $fichier
                    );

                    $Media = new MediaUrl();
                    $Media->setMimeType($mimeType);
                    $Media->setCreatedAt(new \DateTimeImmutable('now'));
                    $Media->setUpdatedAt(new \DateTimeImmutable('now'));
                    $Media->setName($fichier);
                    $Media->setUrlLink($fichier);
                    $Media->setIsMain(false);
                    $this->entityManager->persist($Media);
                    $product->getProductVariations()[0]->addMediaUrl($Media);
                }
                $product->setUpdatedAt(new \DateTimeImmutable('now'));
                $newCategories = $this->entityManager->getRepository(Category::class)->getCategoriesByCodes($request->get('multi-selected-json'));
                $product->updateCategories($newCategories);
                $this->entityManager->persist($product);
                $this->entityManager->flush();

            }
            catch (\Exception $e)
            {
                $this->addFlash("danger",  "Oups! quelque chose c'est mal passé ");
            }
            $this->addFlash("success",  "Produit modifié ");
            return $this->redirectToRoute('product_edit',['id' => $product->getId()]);
        }
        $productVariation=null;
        if($product->isHasVariation()) {

            $productVariation = $this->entityManager->getRepository(ProductVariation::class)->getVariationForListFromProductID($product->getId());
        }

        $MediaUrlVariantArray = $this->entityManager->getRepository(MediaUrl::class)->getMainMediaUrlForVariantsFromProduct($product->getProductVariations()->toArray());


//        dd($form);
        return $this->render('Pages/Product/product_edit.html.twig',[
            'arrayTest'=> json_encode($returnedArray),
            'selectedValues' => json_encode($codesCat),
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