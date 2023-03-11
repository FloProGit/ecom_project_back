<?php



namespace App\Controller;





use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductEditController extends AbstractController
{
    public function index() : response
    {
        return $this->render('Pages/Product/product_edit.html.twig',['arrayTest'=> json_encode(['patate','tomate','navet','saucisse','pomme de terre','voiture'])]);
    }
}