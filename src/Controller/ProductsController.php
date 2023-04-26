<?php



namespace App\Controller;





use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Filesystem\Filesystem;

use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
class ProductsController extends AbstractController
{
    public function __construct(private ProductRepository $productRepository)
    {

    }

    public function index() : response
    {
        $result = $this->productRepository->getProductsForList();
        return $this->render('Pages/Product/products.html.twig',['products' => $result]);
    }


}