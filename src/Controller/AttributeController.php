<?php declare(strict_types=1);



namespace App\Controller;



use App\Entity\Attribute;
use App\Form\AttributeType;
use App\Repository\AttributeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\CanDo;

final class AttributeController extends AbstractController
{

    private AttributeRepository $attributeRepository;
    private EntityManagerInterface $entityManager;
    public function __construct(AttributeRepository $attributeRepository ,EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->attributeRepository = $attributeRepository;
    }

    public function index()
    {
        $result = $this->attributeRepository->findAll();

        $discountForms = array_map(function ($attribute) {
            return $this->createForm(AttributeType::class,$attribute)->createView();
        }, $result);

        $formularCreation = $this->createForm(AttributeType::class, new Attribute())->createView();

        return $this->render('Pages/Attribute/attribute.html.twig', [
             'breadcrumbs' => [
                ['data' => ['name' => 'Attribute']]
            ]
            ,
            'attribute_forms_array' => $discountForms,
            'attribute_forms_create' => $formularCreation
        ]);
    }
    #[CanDo(['ROLE_SUPER_ADMIN','ROLE_ADMIN'],'attribute_list')]
    public function saveAttribute(Attribute $attribute , Request $request): Response
    {
        $form = $this->createForm(AttributeType::class,$attribute);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            try {
                $attribute = $form->getData();
                $attribute->setUpdatedAt(new \DateTimeImmutable('now'));
                $this->entityManager->persist($attribute);
                $this->entityManager->flush();
                $this->addFlash("success",  "Contient le contenu de la notification ");
            }catch(\Exception $e)
            {
                $this->addFlash("danger",  "Oups! quelque chose c'est mal passé ");
            }

        }
        return $this->redirectToRoute('attribute_list');
    }

    #[CanDo(['ROLE_SUPER_ADMIN','ROLE_ADMIN'],'attribute_list')]
    public function createAttribute(Request $request): Response
    {
        $attributeForm = $this->createForm(AttributeType::class,new Attribute());

        $attributeForm->handleRequest($request);


        if($attributeForm->isSubmitted() && $attributeForm->isValid())
        {
            try {
                $attribute = $attributeForm->getData();
                $attribute->setUpdatedAt(new \DateTimeImmutable('now'));
                $attribute->setCreatedAt(new \DateTimeImmutable('now'));
                $this->entityManager->persist($attribute);
                $this->entityManager->flush();
                $this->addFlash("success",  "Contient le contenu de la notification ");
            }catch(\Exception $e)
            {
                $this->addFlash("danger",  "Oups! quelque chose c'est mal passé ");
            }
        }
        return $this->redirectToRoute('attribute_list');
    }
    #[CanDo(['ROLE_SUPER_ADMIN','ROLE_ADMIN'],'attribute_list')]
    public function deleteAttribute(Attribute $attribute): Response
    {
        try{
            $this->entityManager->remove($attribute);
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
