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
        $haystack=[2570,2580];
        $returnedArray = [];
        foreach ($resultCategoryRequest as $key=>$value)
        {
            $returnedArray[$key] = ['label'=>$value,'selected'=>in_array($key,$haystack)];
        }
//        dd($returnedArray);

        return $this->render('Pages/Product/product_edit.html.twig',
            [
                'arrayTest'=> json_encode($returnedArray),
                'selectedValues' => json_encode([2570,2580])
            ]);
    }
}
//{
//    "2570": "Mode Accessoires",
//    "2573": "Vêtements et Chaussures",
//    "2575": "Sous-vêtements",
//    "2577": "Pyjamas et couvertures avec manches",
//    "2580": "Autres vêtements",
//    "2582": "Autres accessoires pour les chaussures",
//    "2584": "Accessoires",
//}
