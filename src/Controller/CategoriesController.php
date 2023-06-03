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
use Symfony\Component\Security\Http\Attribute\CanDo;
use Symfony\Contracts\Translation\TranslatorInterface;

class CategoriesController extends AbstractController
{
    private CategoryRepository $categoryRepository;
    private EntityManagerInterface $entityManager;
    private TranslatorInterface $t;

    public function __construct(
        CategoryRepository     $categoryRepository,
        EntityManagerInterface $entityManager,
        TranslatorInterface    $t
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->entityManager = $entityManager;
        $this->t = $t;
    }

    public function index(): response
    {
        return $this->render('Pages/Category/categories.html.twig', [
            'categories' => $this->categoryRepository->findAll(),
            'breadcrumbs' => [
                ['data' => ['name' => $this->t->trans('categories', domain: 'general')]]
            ]
            ,'navbardata' => json_encode(['fm'=> 'catalogue','sm'=>'categories'])
        ]);
    }

    #[CanDo(['ROLE_SUPER_ADMIN', 'ROLE_ADMIN'], 'categories_list')]
    public function editCategory(Category $category, Request $request): response
    {

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $category = $form->getData();

                $categoryParent = $form->get('id_parent')->getData();

                $category->setIdParent($categoryParent->getIdParent());
                $category->setParent($categoryParent->getName());
                $category->setUpdatedAt(new \DateTimeImmutable('now'));

                $this->entityManager->persist($category);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                dd($e);
            }
        }
        return $this->render('Pages/Category/category_edit.html.twig', [
            'category' => $category,
            'breadcrumbs' => [
                ['route' => 'products_list', 'data' => ['name' => $this->t->trans('categories', domain: 'general')]],
                ['data' => ['name' => $category->getName()]]
            ],
            'form' => $form->createView(),
            'navbardata' => json_encode(['fm'=> 'catalogue','sm'=>'categories'])
        ]);

    }

    #[CanDo(['ROLE_SUPER_ADMIN', 'ROLE_ADMIN'], 'categories_list')]
    public function createCategory(Request $request): response
    {
        $category = new Category();


        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $category = $form->getData();
                $category->setCreatedAt(new \DateTimeImmutable('now'));
                $category->setUpdatedAt(new \DateTimeImmutable('now'));
                $this->entityManager->persist($category);
                $this->entityManager->flush();


            } catch (\Exception $e) {
                dd($e);
            }
        }

        return $this->render('Pages/Category/category_create.html.twig', [
            'form' => $form->createView(),
            'breadcrumbs' => [
                ['route' => 'products_list', 'data' => ['name' => $this->t->trans('categories', domain: 'general')]],
                ['data' => ['name' => $this->t->trans('new_f', domain: 'general').' '.$this->t->trans('category', domain: 'general')]]
            ],'navbardata' => json_encode(['fm'=> 'catalogue','sm'=>'categories'])
        ]);
    }

}
