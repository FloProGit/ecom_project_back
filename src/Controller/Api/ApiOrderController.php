<?php declare(strict_types=1);


namespace App\Controller\Api;


use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\ProductVariation;
use App\Repository\OrderRepository;
use App\Repository\ProductVariationRepository;
use App\Repository\UserRepository;
use App\Services\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
final class ApiOrderController extends AbstractController
{
    private OrderRepository $orderRepository;
    private ProductVariationRepository $productVariationRepository;
    private JWTTokenManagerInterface $jwtManager;
    private JWTEncoderInterface $JWTEncoder;

    private EntityManagerInterface $entityManager;
    public function __construct(
        OrderRepository            $orderRepository,
        ProductVariationRepository $productVariationRepository,
        UserRepository             $userRepository,
        JWTTokenManagerInterface $jwtManager,
         JWTEncoderInterface $JWTEncoder,
        EntityManagerInterface $entityManager
    )
    {
        $this->orderRepository = $orderRepository;
        $this->productVariationRepository = $productVariationRepository;
        $this->jwtManager = $jwtManager;
        $this->userRepository = $userRepository;
        $this->JWTEncoder = $JWTEncoder;
        $this->entityManager = $entityManager;
    }


    public function createOrderFromCart(Request $request)
    {




        $jsonContent = json_decode($request->getContent(), true);
        $cart = json_decode($jsonContent["cart"],true);
        $token = $jsonContent["token"];



        $token = $this->JWTEncoder->decode($token);
        $User = $this->userRepository->findOneBy(['email'=>$token["username"]]);

        //SQL EXEMPLE
        //INSERT INTO `order` (user_id,order_ext_id,created_at) VALUES (1,"000000000000",NOW())
        //INSERT INTO order_product (product_id,order_id_id,quantity) VALUES (1,24,5)

        foreach ($cart as $id => $value) {
            $order = new Order();
            $orderProduct = new OrderProduct();
            $productV =  $this->productVariationRepository->find($id);
            $date = new \DateTimeImmutable();
            $formatedDate = $date->format("YmdHis");
            $order->setCreatedAt($date);
            $order->setOrderExtId($formatedDate.strVal($productV->getPriceTaxExclude()*$value));

            $order->setUser($User);

            $orderProduct->setProduct($productV);
            $orderProduct->setQuantity($value);
            $orderProduct->setOrderID($order);
            $this->entityManager->persist($orderProduct);
            $this->entityManager->persist($order);
        }
        $this->entityManager->flush();
        return $this->json("Order Create",200,[]);

    }

    public function getOrders(Request $request)
    {
        $token = $request->query->get('token');

        $token = $this->JWTEncoder->decode($token);
        $User = $this->userRepository->findOneBy(['email'=>$token["username"]]);
//        $order = $this->orderRepository->findOneBy(['user' => $User->getId()]);
        $order = $this->orderRepository->getOrderProductByUser($User->getId());

        //Autre solution créé un json a retourné avec seulement les infos que l'on a besoin
       dd($order);

//        $order = $this->orderRepository->getOrderProductByUser($User->getId());
//        dd($this->json($order,200,[],[AbstractNormalizer::GROUPS => ['front_orders']])->getContent());
//        dd(json_decode($this->json($order,200,[],[AbstractNormalizer::GROUPS => ['front_orders']])->getContent(),true));
        return $this->json($order,200,[]);

    }
}
