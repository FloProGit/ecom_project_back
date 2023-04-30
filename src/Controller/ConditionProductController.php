<?php



namespace App\Controller;





use App\Entity\ConditionProduct;
use App\Repository\ConditionProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ConditionProductController extends AbstractController
{
    private ConditionProductRepository $conditionProductRepository;
    private EntityManagerInterface $entityManager;
    public function __construct( ConditionProductRepository $conditionProductRepository, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->conditionProductRepository = $conditionProductRepository;
    }

    public function index() : response
    {
        $result = $this->conditionProductRepository->findAll();

        $Conditonsforms = array_map(function($condition){

        },$result);

        return $this->render('Pages/ConditionProduct/condition_product.html.twig',[
            'conditions' => $result,'breadcrumbs'=>[
                ['data' => ['name' => 'ConditionProduct']]
            ]]);
    }

}