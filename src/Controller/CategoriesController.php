<?php



namespace App\Controller;





use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoriesController extends AbstractController
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private EntityManagerInterface $entityManager
    ){
    }

    public function index() : response
    {
        return $this->render('Pages/Category/categories.html.twig',[
            'categories' => $this->categoryRepository->findAll(),
            'breadcrumbs'=>[
                ['data' => ['name' => 'Categories']]
            ]
        ]);
    }

    public function editCategory(Category $category,Request $request) : response
    {

        $form = $this->createForm(CategoryType::class,$category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            try {
                $category = $form->getData();

                $categoryParent = $form->get('id_parent')->getData();

                $category->setIdParent($categoryParent->getIdParent());
                $category->setParent($categoryParent->getName());
                $category->setUpdatedAt(new \DateTimeImmutable('now'));

                $this->entityManager->persist($category);
                $this->entityManager->flush();
            }
            catch (\Exception $e)
            {
                dd($e);
            }
        }
        return $this->render('Pages/Category/category_edit.html.twig',[
            'category' => $category,
            'breadcrumbs'=>[
                ['route'=> 'products_list','data' => ['name' => 'Categories']],
                ['data' => ['name' => $category->getName()]]
            ],
            'form'=> $form->createView(),
        ]);

    }
    public function createCategory(Request $request) : response
    {
        $category = new Category();


        $form = $this->createForm(CategoryType::class,$category);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            try {
                $category = $form->getData();
                $category->setCreatedAt(new \DateTimeImmutable('now'));
                $category->setUpdatedAt(new \DateTimeImmutable('now'));
                $this->entityManager->persist($category);
                $this->entityManager->flush();


            }
            catch (\Exception $e)
            {
                dd($e);
            }
        }

        return $this->render('Pages/Category/category_edit.html.twig',[
            'form'=> $form->createView(),
            'breadcrumbs'=>[
                ['route'=> 'products_list','data' => ['name' => 'Categories']],
                ['data' => ['name' => 'New category']]
            ],
        ]);
    }

}
