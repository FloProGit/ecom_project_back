<?php



namespace App\Controller;





use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductsController extends AbstractController
{

    public function index() : response
    {
        return $this->render('Pages/Product/products.html.twig');
    }


}