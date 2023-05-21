<?php


namespace App\Controller;


use App\Entity\Category;
use App\Entity\ConditionProduct;
use App\Entity\MediaUrl;
use App\Entity\Product;
use App\Entity\ProductVariation;
use App\Form\ProductType;
use App\Form\ProductVariationType;
use App\Repository\ProductRepository;
use App\Services\Factory\MultiMediaUrlFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Http\Attribute\CanDo;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ProductsController extends AbstractController
{
    public function __construct(
        private ProductRepository $productRepository,
        private EntityManagerInterface $entityManager,
        private MultiMediaUrlFactory $multiMediaUrlFactory)
    {

    }

    public function index(): Response
    {
        $result = $this->productRepository->getProductsForList();
        return $this->render('Pages/Product/products.html.twig', [
            'products' => $result, 'breadcrumbs' => [
                ['data' => ['name' => 'Product']]
            ]]);
    }
    #[CanDo(['ROLE_SUPER_ADMIN','ROLE_ADMIN'],'products_list')]
    public function editProduct(Product $product, Request $request): Response
    {
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        //create data categories for product category multiselect in view
        $resultCategoryRequest = $this->entityManager->getRepository(Category::class)->getAllNameArray();
        $categoriesProduct = $product->getCategories()->ToArray();

        $codesCat = array_map(function (Category $category) {
            return $category->getCode();
        }, $categoriesProduct);
        $haystack = $codesCat;

        $returnedArray = [];
        foreach ($resultCategoryRequest as $key => $value) {

            $returnedArray[$key] = ['label' => $value, 'selected' => in_array($key, $haystack)];
        }

        //when form is submit
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $product = $form->getData();
                if (!$product->isHasVariation()) {
                    $images = $form->get('productVariations')[0]->get('images')->getData();
                    $mediaUrls = $this->multiMediaUrlFactory->buildMediaUrls($images,$this->getParameter('images_directory') );


                    $product->getProductVariations()[0]->addMultipleMediaUrl($mediaUrls);
                }
                $product->setUpdatedAt(new \DateTimeImmutable('now'));
                $newCategories = $this->entityManager->getRepository(Category::class)->getCategoriesByCodes($request->get('multi-selected-json'));
                $product->updateCategories($newCategories);
                $this->entityManager->persist($product);
                $this->entityManager->flush();
                $this->addFlash("success", "Produit modifié ");

            } catch (\Exception $e) {
                $this->addFlash("danger", "Oups! quelque chose c'est mal passé ");
            }
            return $this->redirectToRoute('product_edit', ['id' => $product->getId()]);
        }

        //if has variation get list of variation in view
        $productVariation = null;

        if ($product->isHasVariation()) {

            $productVariation = $this->entityManager->getRepository(ProductVariation::class)->getVariationForListFromProductID($product->getId());
        }

        //get list of main variation image url
        $MediaUrlVariantArray = $this->entityManager->getRepository(MediaUrl::class)->getMainMediaUrlForVariantsFromProduct($product->getProductVariations()->toArray());

        return $this->render('Pages/Product/product_edit.html.twig', [
            'arrayTest' => json_encode($returnedArray),
            'selectedValues' => json_encode($codesCat),
            'breadcrumbs' => [
                ['route' => 'products_list', 'data' => ['name' => 'Product']],
                ['data' => ['name' => $product->getName()]]
            ],
            'productsVariation' => $productVariation,
            'MediaUrlVariantArray' => $MediaUrlVariantArray,
            'hasVaration' => $product->isHasVariation(),
            'product_form' => $form->createView(),
        ]);

    }
    #[CanDo(['ROLE_SUPER_ADMIN','ROLE_ADMIN'],'products_list')]
    public function createProduct( Request $request): Response
    {
        $newProduct = new Product();
        $productVariation = new ProductVariation();
        $newProduct->addProductVariation($productVariation);
        $form = $this->createForm(ProductType::class, $newProduct);
        $form->handleRequest($request);

        //create data categories for product category multiselect in view
        $resultCategoryRequest = $this->entityManager->getRepository(Category::class)->getAllNameArray();

        $returnedArray = [];
        foreach ($resultCategoryRequest as $key => $value) {

            $returnedArray[$key] = ['label' => $value, 'selected' => false];
        }

        //when form is submit
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $product = $form->getData();
                $product->setHasVariation(false);
                if (!$product->isHasVariation()) {
                    $images = $form->get('productVariations')[0]->get('images')->getData();
                    $mediaUrls = $this->multiMediaUrlFactory->buildMediaUrls($images,$this->getParameter('images_directory') );
                    $product->getProductVariations()[0]->addMultipleMediaUrl($mediaUrls);
                }

                $product->setUpdatedAt(new \DateTimeImmutable('now'));
                $newCategories = $this->entityManager->getRepository(Category::class)->getCategoriesByCodes($request->get('multi-selected-json'));

                $product->updateCategories($newCategories);
                $product->setCreatedAt(new \DateTimeImmutable());
                $product->setUpdatedAt(new \DateTimeImmutable());
                $productVariation->setCreatedAt(new \DateTimeImmutable());
                $productVariation->setUpdatedAt(new \DateTimeImmutable());
                $productVariation->setIsMain(true);

                $this->entityManager->persist($productVariation);
                $this->entityManager->persist($product);
                $this->entityManager->flush();

                $this->addFlash("success", "Produit modifié ");

            } catch (\Exception $e) {
                dd($e->getMessage());
                $this->addFlash("danger", "Oups! quelque chose c'est mal passé ");
            }

            return $this->redirectToRoute('products_list');
        }

        return $this->render('Pages/Product/product_create.html.twig', [
            'arrayTest' => json_encode($returnedArray),
            'selectedValues' => json_encode([]),
            'breadcrumbs' => [
                ['route' => 'products_list', 'data' => ['name' => 'New Product']
                ]
            ],
            'productsVariation' => $productVariation,
            'hasVaration' => false,
            'product_form' => $form->createView(),
        ]);

    }
}
