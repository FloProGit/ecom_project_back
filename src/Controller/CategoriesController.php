<?php



namespace App\Controller;





use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoriesController extends AbstractController
{

    public function index(CategoryRepository $categoryRepository) : response
    {
        return $this->render('Pages/Category/categories.html.twig',[
            'categories' => $categoryRepository->findAll(),
            'breadcrumbs'=>[
                ['data' => ['name' => 'Categories']]
            ]
        ]);
    }


}