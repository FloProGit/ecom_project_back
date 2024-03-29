<?php


namespace App\Controller;


use App\Entity\ConditionProduct;
use App\Form\ConditionProductType;
use App\Repository\ConditionProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\CanDo;
use Symfony\Contracts\Translation\TranslatorInterface;

class ConditionProductController extends AbstractController
{
    private ConditionProductRepository $conditionProductRepository;
    private EntityManagerInterface $entityManager;
    private TranslatorInterface $t;
    public function __construct(ConditionProductRepository $conditionProductRepository, EntityManagerInterface $entityManager, TranslatorInterface $t)
    {
        $this->entityManager = $entityManager;
        $this->conditionProductRepository = $conditionProductRepository;
        $this->t = $t;
    }

    public function index(): response
    {
        $result = $this->conditionProductRepository->findAll();

        $ConditonsForms = array_map(function ($condition) {
            return $this->createForm(ConditionProductType::class, $condition)->createView();
        }, $result);

        $formularCreation = $this->createForm(ConditionProductType::class, new ConditionProduct())->createView();
        return $this->render('Pages/ConditionProduct/condition_product.html.twig', [
            'conditions' => $result, 'breadcrumbs' => [
                ['data' => ['name' => $this->t->trans('conditions', domain: 'general')]]
            ]
            ,
            'conditions_forms_array' => $ConditonsForms,
            'conditions_forms_create' => $formularCreation
            ,'navbardata' => json_encode(['fm'=> 'catalogue','sm'=>'condition_product'])
        ]);
    }
    #[CanDo(['ROLE_SUPER_ADMIN','ROLE_ADMIN'],'condition_product_list')]
    public function saveConditionProduct(ConditionProduct $conditionProduct ,Request $request) : response
    {
        $conditionProduct = $this->createForm(ConditionProductType::class, $conditionProduct);

        $conditionProduct->handleRequest($request);

        if ($conditionProduct->isSubmitted() && $conditionProduct->isValid()) {
            try {
                $conditionProductData = $conditionProduct->getData();
                $this->entityManager->persist($conditionProductData);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash("danger",  "Oups! quelque chose c'est mal passé ");
            }
        }
        $this->addFlash("success",  "Contient le contenu de la notification ");
        return $this->redirectToRoute('condition_product_list');
    }
    #[CanDo(['ROLE_SUPER_ADMIN','ROLE_ADMIN'],'condition_product_list')]
    public function createConditionProduct(Request $request) : response
    {
        $conditionProduct = $this->createForm(ConditionProductType::class, new ConditionProduct());

        $conditionProduct->handleRequest($request);

        if ($conditionProduct->isSubmitted() && $conditionProduct->isValid()) {
            try {
                $conditionProductData = $conditionProduct->getData();
                $this->entityManager->persist($conditionProductData);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash("danger",  "Oups! quelque chose c'est mal passé ");
            }
        }
        $this->addFlash("success",  "Contient le contenu de la notification ");
        return $this->redirectToRoute('condition_product_list');
    }
    #[CanDo(['ROLE_SUPER_ADMIN'],'condition_product_list')]
    public function deleteConditionProduct(ConditionProduct $conditionProduct,Request $request) : response
    {
        try{
        $this->entityManager->remove($conditionProduct);
        $this->entityManager->flush();
        }
        catch (\Exception $e)
        {
            $this->addFlash("danger",  "Oups! quelque chose c'est mal passé ");
            return $this->redirectToRoute('condition_product_list');

        }
        $this->addFlash("warning",  "suppression effectué");
        return $this->redirectToRoute('condition_product_list');
    }
}
