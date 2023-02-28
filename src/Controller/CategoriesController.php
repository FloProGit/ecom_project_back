<?php



namespace App\Controller;





use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoriesController extends AbstractController
{

    public function index() : response
    {
        return $this->render('Pages/Product/categories.html.twig');
    }


}