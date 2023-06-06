<?php declare(strict_types=1);


namespace App\Controller\Api;




use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

final class ApiOrderController extends AbstractController
{
    private OrderRepository $orderRepository;
    public function __construct(
        OrderRepository $orderRepository
    )
    {
        $this->orderRepository = $orderRepository;
    }


    public function createOrderFromCart(Request $request)
    {
        $result = $request->query->get('cart');
        $cart = json_decode($result,true);
        dd($cart);
    }

}
