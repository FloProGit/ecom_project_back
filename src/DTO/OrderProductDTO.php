<?php
namespace App\DTO;

use App\Entity\OrderProduct;

class OrderProductDTO
{
    private $id;
    private $productName;
    private $quantity;

    public function __construct(OrderProduct $orderProduct)
    {
        $this->id = $orderProduct->getId();
        $this->productName = $orderProduct->getProduct()->getName();
        $this->quantity = $orderProduct->getQuantity();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }
}
