<?php

declare(strict_types=1);


namespace App\Controller;



use App\Entity\TaxRule;
use App\Form\TaxRuleType;
use App\Repository\TaxRuleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\CanDo;
use Symfony\Contracts\Translation\TranslatorInterface;

final class TaxRuleController extends AbstractController
{
    private TaxRuleRepository $taxRuleRepository;
    private EntityManagerInterface $entityManager;
    private  TranslatorInterface $t;

    public function __construct(TaxRuleRepository $taxRuleRepository, EntityManagerInterface $entityManager,TranslatorInterface $t)
    {
        $this->taxRuleRepository = $taxRuleRepository;
        $this->entityManager = $entityManager;
        $this->t = $t;
    }


    public function index()
    {
        $result = $this->taxRuleRepository->findAll();

        $taxRuleForms = array_map(function ($discount) {
            return $this->createForm(TaxRuleType::class,$discount)->createView();
        }, $result);

        $formularCreation = $this->createForm(TaxRuleType::class, new TaxRule())->createView();

        return $this->render('Pages/TaxRule/tax_rule.html.twig', [
            'breadcrumbs' => [
                ['data' => ['name' => $this->t->trans('tax_rules', domain: 'general')]]
            ]
            ,
            'tax_rule_forms_array' => $taxRuleForms,
            'tax_rule_forms_create' => $formularCreation,
            'navbardata' => json_encode(['fm'=> 'catalogue','sm'=>'tax_rules'])
        ]);
    }
    #[CanDo(['ROLE_SUPER_ADMIN','ROLE_ADMIN'],'tax_rule_list')]
    public function saveTaxRule(TaxRule $taxRule,Request $request): Response
    {
        $form = $this->createForm(TaxRuleType::class,$taxRule);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            try {
                $taxRule = $form->getData();
                $taxRule->setUpdatedAt(new \DateTimeImmutable('now'));
                $this->entityManager->persist($taxRule);
                $this->entityManager->flush();
                $this->addFlash("success",  "Contient le contenu de la notification ");
            }catch(\Exception $e)
            {
                $this->addFlash("danger",  "Oups! quelque chose c'est mal passé ");
            }

        }
        return $this->redirectToRoute('tax_rule_list');

    }
    #[CanDo(['ROLE_SUPER_ADMIN','ROLE_ADMIN'],'tax_rule_list')]
    public function createTaxRule(Request $request): Response
    {
        $taxRuleForm = $this->createForm(TaxRuleType::class,new TaxRule());

        $taxRuleForm->handleRequest($request);


        if($taxRuleForm->isSubmitted() && $taxRuleForm->isValid())
        {
            try {
                $taxRule = $taxRuleForm->getData();
                $taxRule->setUpdatedAt(new \DateTimeImmutable('now'));
                $taxRule->setCreatedAt(new \DateTimeImmutable('now'));
                $this->entityManager->persist($taxRule);
                $this->entityManager->flush();
                $this->addFlash("success",  "Contient le contenu de la notification ");
            }catch(\Exception $e)
            {
                $this->addFlash("danger",  "Oups! quelque chose c'est mal passé ");
            }
        }
        return $this->redirectToRoute('tax_rule_list');

    }
    #[CanDo(['ROLE_SUPER_ADMIN','ROLE_ADMIN'],'tax_rule_list')]
    public function deleteTaxRule(TaxRule $taxRule): Response
    {
        try{
            $this->entityManager->remove($taxRule);
            $this->entityManager->flush();
            $this->addFlash("warning",  "suppression effectué");
        }
        catch (\Exception $e)
        {
            $this->addFlash("danger",  "Oups! quelque chose c'est mal passé ");
        }
        return $this->redirectToRoute('tax_rule_list');

    }
}
