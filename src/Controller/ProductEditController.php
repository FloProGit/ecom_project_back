<?php



namespace App\Controller;





use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductEditController extends AbstractController
{

    public function __construct(private CategoryRepository $categoryRepository)
    {
    }

    public function index() : response
    {
        $resultCategoryRequest =$this->categoryRepository->getAllNameArray();


        return $this->render('Pages/Product/product_edit.html.twig',['arrayTest'=> json_encode($resultCategoryRequest)]);
    }
}