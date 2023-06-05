<?php declare(strict_types=1);


namespace App\Controller\Api;




use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

final class ApiProductController extends AbstractController
{
    private ProductRepository $productRepository;
    public function __construct(
        ProductRepository $productRepository
    )
    {
        $this->productRepository = $productRepository;
    }

    public function allProduct(ProductRepository $productRepository):JsonResponse
    {
         $result = $this->productRepository->getProductsForList();
         return $this->json($result,200,[]);
    }

    public function productById (Request $request):JsonResponse
    {

        $id = intval( $request->get('id'));
        $result = $this->productRepository->getProductBy($id);

        return $this->json($result,200,[],[AbstractNormalizer::GROUPS => ['front_product']]);


    }
}
