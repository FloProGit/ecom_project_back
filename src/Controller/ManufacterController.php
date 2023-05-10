<?php



namespace App\Controller;





use App\Entity\Category;
use App\Entity\Manufacter;
use App\Entity\MediaUrl;
use App\Entity\Product;
use App\Entity\ProductVariation;
use App\Form\ManufacterType;
use App\Form\ProductType;
use App\Form\ProductVariationType;
use App\Repository\ManufacterRepository;
use App\Repository\ProductRepository;
use App\Services\Infrastructure\ErrorFromHandlingTransformer;
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

        $manufactersForms = array_map(function ($manufacter) {
            return $this->createForm(ManufacterType::class, $manufacter)->createView();
        }, $result);

        $formularCreation = $this->createForm(ManufacterType::class, new Manufacter())->createView();
        return $this->render('Pages/Manufacter/manufacter.html.twig', [
            'manufacters' => $result,'breadcrumbs'=>[
                ['data' => ['name' => 'Manufacter']]
            ]
            ,
            'manufacter_forms_array' => $manufactersForms,
            'manufacter_form_create' => $formularCreation
        ]);
    }

    public function saveManufacter(Manufacter $manufacter ,Request $request) : response
    {
        $manufacter = $this->createForm(ManufacterType::class, $manufacter);

        $manufacter->handleRequest($request);

        if ($manufacter->isSubmitted() && $manufacter->isValid()) {
            try {
                $manufacterData = $manufacter->getData();
                $this->entityManager->persist($manufacterData);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash("danger",  "Oups! quelque chose c'est mal passé ");
            }
        }
        $this->addFlash("success",  "Contient le contenu de la notification ");
        return $this->redirectToRoute('manufacter_list');
    }

    public function createManufacter(Request $request) : response
    {
        $manufacter = $this->createForm(ManufacterType::class, new Manufacter());

        $manufacter->handleRequest($request);

        if ($manufacter->isSubmitted() && $manufacter->isValid()) {
            try {
                $manufacterData = $manufacter->getData();
                $this->entityManager->persist($manufacterData);
                $this->entityManager->flush();
                $this->addFlash("success",  'Manufacter' .$manufacterData->getName().'Add');
            } catch (\Exception $e) {
                $this->addFlash("danger",  "Oups! quelque chose c'est mal passé ");
            }
        }
        else{
            $errorTransformer = new ErrorFromHandlingTransformer($manufacter->getErrors(true));
            $this->addFlash("danger",  $errorTransformer->__toString());
        }

        return $this->redirectToRoute('manufacter_list');
    }

    public function deleteManufacter(Manufacter $manufacter) : response
    {
        try{
            $this->entityManager->remove($manufacter);
            $this->entityManager->flush();
        }
        catch (\Exception $e)
        {
            $this->addFlash("danger",  "Oups! quelque chose c'est mal passé ");
            return $this->redirectToRoute('manufacter_list');

        }
        $this->addFlash("warning",  "suppression effectué");
        return $this->redirectToRoute('manufacter_list');
    }
}