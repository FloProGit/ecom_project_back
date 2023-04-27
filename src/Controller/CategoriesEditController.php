<?php



namespace App\Controller;





use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoriesEditController extends AbstractController
{
    public function index(Category $category) : response
    {
        return $this->render('Pages/Category/category_edit.html.twig',[
            'category' => $category,
            'breadcrumbs'=>[
                ['route'=> 'products_list','data' => ['name' => 'Categories']],
                ['data' => ['name' => $category->getName()]]
            ]
        ]);
    }

    public function saveCategory(Category $category,Request $request ,CategoryRepository $categoryRepository) : response
    {
        dd($category);

        $form = $this->createForm(Category::class, $category, ['method' => 'PUT']);

        $form->handleRequest($request);

        $categoryRepository->save($category);

        return $this->render('Pages/Category/category_edit.html.twig',[
            'category' => $category,
            'breadcrumbs'=>[
                ['route'=> 'products_list','data' => ['name' => 'Categories']],
                ['data' => ['name' => $category->getName()]]
            ]
        ]);
    }


}