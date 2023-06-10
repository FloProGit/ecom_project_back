<?php

namespace App\Entity;

use App\Repository\OrderProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderProductRepository::class)]
class OrderProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['front_orders'])]
    private ?int $id = null;



    #[ORM\ManyToOne(targetEntity: ProductVariation::class, fetch: "EAGER",inversedBy: 'orderProducts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['front_orders'])]
    private ?ProductVariation $Product = null;

    #[ORM\Column]
    #[Groups(['front_orders'])]
    private ?int $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'OrderProduct')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $OrderID = null;

    public function getId(): ?int
    {
        return $this->id;
    }





    public function getProduct(): ?ProductVariation
    {
        return $this->Product;
    }

    public function setProduct(?ProductVariation $Product): self
    {
        $this->Product = $Product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getOrderID(): ?Order
    {
        return $this->OrderID;
    }

    public function setOrderID(?Order $OrderID): self
    {
        $this->OrderID = $OrderID;

        return $this;
    }
}
