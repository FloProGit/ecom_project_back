<?php declare(strict_types=1);


namespace App\Controller\Api;




use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ApiProductController extends AbstractController
{

    public function index(ProductRepository $productRepository)
    {
         $result = $productRepository->getProductsForList();
         return $this->json($result,200,[]);
    }


}
