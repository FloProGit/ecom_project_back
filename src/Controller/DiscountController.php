<?php
declare(strict_types=1);
namespace App\Controller;


use App\Entity\Discount;
use App\Form\DiscountType;
use App\Repository\DiscountRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\CanDo;

final class DiscountController extends AbstractController
{
    private DiscountRepository $discountRepository;
    private EntityManagerInterface $entityManager;
    public function __construct(DiscountRepository $discountRepository,EntityManagerInterface $entityManager)
    {
        $this->discountRepository = $discountRepository;
        $this->entityManager = $entityManager;
    }

    public function index()
    {
        $result = $this->discountRepository->findAll();

        $discountForms = array_map(function ($discount) {
            return $this->createForm(DiscountType::class,$discount)->createView();
        }, $result);

        $formularCreation = $this->createForm(DiscountType::class, new Discount())->createView();

        return $this->render('Pages/Discount/discount.html.twig', [
            'discounts' => $result, 'breadcrumbs' => [
                ['data' => ['name' => 'Discounts']]
            ]
            ,
            'discount_forms_array' => $discountForms,
            'discount_forms_create' => $formularCreation
        ]);
    }
    #[CanDo(['ROLE_ADMIN','ROLE_USER'],'discount_list')]
    public function saveDiscount(Discount $discount,Request $request): Response
    {

        $form = $this->createForm(DiscountType::class,$discount);

        //to change string date in dateImmutable in Request
        $dateFrom = DateTimeImmutable::createFromFormat("Y-m-d", date("Y-m-d", strtotime($request->request->all()['discount']['discount_from'])));
        $dateTo = DateTimeImmutable::createFromFormat("Y-m-d", date("Y-m-d", strtotime($request->request->all()['discount']['discount_to'])));

        $request->request->all();
        $newRequest['discount']['discount_from'] = $dateFrom;
        $newRequest['discount']['discount_to'] = $dateTo;

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid())
        {
            try {
                $discount = $form->getData();
                $discount->setUpdatedAt(new \DateTimeImmutable('now'));
                $this->entityManager->persist($discount);
                $this->entityManager->flush();
                $this->addFlash("success",  "Contient le contenu de la notification ");
            }catch(\Exception $e)
            {
                $this->addFlash("danger",  "Oups! quelque chose c'est mal passé ");
            }

        }
        return $this->redirectToRoute('discount_list');
    }
    #[CanDo(['ROLE_ADMIN','ROLE_USER'],'discount_list')]
    public function createDiscount(Request $request): Response
    {

        $discountForm = $this->createForm(DiscountType::class,new Discount());

        $discountForm->handleRequest($request);


        if($discountForm->isSubmitted() && $discountForm->isValid())
        {
            try {
                $discount = $discountForm->getData();
                $discount->setUpdatedAt(new \DateTimeImmutable('now'));
                $discount->setCreatedAt(new \DateTimeImmutable('now'));
                $this->entityManager->persist($discount);
                $this->entityManager->flush();
                $this->addFlash("success",  "Contient le contenu de la notification ");
            }catch(\Exception $e)
            {
                $this->addFlash("danger",  "Oups! quelque chose c'est mal passé ");
            }
        }
        return $this->redirectToRoute('discount_list');
    }
    public function deleteDiscount(Discount $discount): Response
    {
        try{
            $this->entityManager->remove($discount);
            $this->entityManager->flush();
            $this->addFlash("warning",  "suppression effectué");
        }
        catch (\Exception $e)
        {
            $this->addFlash("danger",  "Oups! quelque chose c'est mal passé ");
        }
        return $this->redirectToRoute('discount_list');
    }


}
