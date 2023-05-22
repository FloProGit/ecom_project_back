<?php


namespace App\Controller;


use App\Entity\MediaUrl;
use App\Entity\Product;
use App\Entity\ProductVariation;
use App\Form\ProductVariationType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\ProductVariationRepository;
use App\Repository\MediaUrlRepository;
use App\Services\Factory\MultiMediaUrlFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\CanDo;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProductVariationController extends AbstractController
{
    private CategoryRepository $categoryRepository;
    private ProductRepository $productRepository;
    private ProductVariationRepository $productVariationRepository;
    private MediaUrlRepository $mediaUrlRepository;
    private EntityManagerInterface $entityManager;
    private MultiMediaUrlFactory $multiMediaUrlFactory;
    private TranslatorInterface $t;

    public function __construct(
        CategoryRepository         $categoryRepository,
        ProductRepository          $productRepository,
        ProductVariationRepository $productVariationRepository,
        MediaUrlRepository         $mediaUrlRepository,
        EntityManagerInterface     $entityManager,
        MultiMediaUrlFactory       $multiMediaUrlFactory,
        TranslatorInterface        $t
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->mediaUrlRepository = $mediaUrlRepository;
        $this->productVariationRepository = $productVariationRepository;
        $this->entityManager = $entityManager;
        $this->multiMediaUrlFactory = $multiMediaUrlFactory;
        $this->t = $t;
    }

    #[CanDo(['ROLE_SUPER_ADMIN', 'ROLE_ADMIN'], 'products_list')]
    public function editProductVariation(ProductVariation $productVariation, Request $request): response
    {

        $form = $this->createForm(ProductVariationType::class, $productVariation);
        $product = $productVariation->getProductId();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $productVariation = $form->getData();

                $productVariation->setUpdatedAt(new \DateTimeImmutable('now'));
                $this->entityManager->persist($productVariation);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                dd($e);
            }
        }

        return $this->render('Pages/ProductVariation/product_variation_edit.html.twig', [
            'breadcrumbs' => [
                ['route' => 'products_list', 'data' => ['name' => $this->t->trans('product', domain: 'general')]],
                ['route' => 'product_edit', 'param' => ['id' => $product->getId()], 'data' => ['name' => $product->getName()]],
                ['data' => ['name' => $this->t->trans('variation', domain: 'general') .' '. $productVariation->getExtReference()]]
            ],
            'variation_form' => $form->createView(),
        ]);
    }

    #[CanDo(['ROLE_SUPER_ADMIN', 'ROLE_ADMIN'], 'products_list')]
    public function createProductVariation(Request $request, ProductRepository $productRepository): response
    {
        $productVariation = new ProductVariation();
        $form = $this->createForm(ProductVariationType::class, $productVariation);

        $form->handleRequest($request);

        $product = $productRepository->find($request->get('product_id'));

        if ($form->isSubmitted() && $form->isValid()) {
            $newId = null;
            try {

                $productVariation = $form->getData();
                $mediaUrls = $this->multiMediaUrlFactory->buildMediaUrls($form->get('images')->getData(), $this->getParameter('images_directory'));
                $productVariation->addMultipleMediaUrl($mediaUrls);
                $productVariation->setIsMain(false);
                $productVariation->setCreatedAt(new \DateTimeImmutable('now'));
                $productVariation->setUpdatedAt(new \DateTimeImmutable('now'));
                $product->addProductVariation($productVariation);
                if (count($product->getProductVariations()->toArray()) > 1) {
                    $product->setHasVariation(true);
                }
                $this->entityManager->persist($productVariation);
                $this->entityManager->persist($product);
                $this->entityManager->flush();
                $newId = $productVariation->getId();
                $this->addFlash("success", "Produit modifié ");
            } catch (\Exception $e) {
                dd($e);
                $this->addFlash("danger", "Oups! quelque chose c'est mal passé ");
            }
            return $this->redirectToRoute('product_variation_edit', ['id' => $newId]);
        }
        return $this->render('Pages/ProductVariation/product_variation_create.html.twig', [
            'breadcrumbs' => [
                ['route' => 'products_list', 'data' => ['name' => $this->t->trans('product', domain: 'general')]],
                ['route' => 'product_edit', 'param' => ['id' => $product->getId()], 'data' => ['name' => $product->getName()]],
                ['data' => ['name' => $this->t->trans('new_variation', domain: 'general')]]
            ],
            'variation_form' => $form->createView(),
        ]);
    }

    #[CanDo(['ROLE_SUPER_ADMIN', 'ROLE_ADMIN'], 'products_list')]
    public function deleteProductVariation(ProductVariation $productVariation): Response
    {
        try {
            $product = $productVariation->getProductId();

            if ((count($product->getProductVariations()->toArray()) - 1) === 1) {
                $product->setHasVariation(false);
                $product->removeProductVariation($productVariation);
                $this->entityManager->persist($product);
            }
            $mediaUrls = $productVariation->getMediaUrls();
            foreach ($mediaUrls as $mediaUrl) {
                $productVariation->removeMediaUrl($mediaUrl);
            }
            $this->entityManager->remove($productVariation);
            $this->entityManager->flush();
            $this->addFlash("warning", "suppression effectué");

        } catch (\Exception $e) {
            $this->addFlash("danger", "Oups! quelque chose c'est mal passé ");
        }
        return $this->redirectToRoute('product_edit', ['id' => $product->getId()]);
    }
}

