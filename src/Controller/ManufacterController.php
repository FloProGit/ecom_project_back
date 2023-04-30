<?php



namespace App\Controller;





use App\Entity\Category;
use App\Entity\MediaUrl;
use App\Entity\Product;
use App\Entity\ProductVariation;
use App\Form\ProductType;
use App\Form\ProductVariationType;
use App\Repository\ManufacterRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ManufacterController extends AbstractController
{
    private ManufacterRepository $manufacterRepository;
    private EntityManagerInterface $entityManager;
    public function __construct( ManufacterRepository $manufacterRepository, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->manufacterRepository = $manufacterRepository;
    }

    public function index() : response
    {
        $result = $this->manufacterRepository->findAll();
        return $this->render('Pages/Manufacter/manufacter.html.twig',[
            'manufacters' => $result,'breadcrumbs'=>[
                ['data' => ['name' => 'Manufacter']]
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
//        dd($form);
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