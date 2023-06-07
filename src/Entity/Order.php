<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['front_orders'])]
    private ?string $order_ext_id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    #[Groups(['front_orders'])]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\OneToMany(mappedBy: 'OrderID', targetEntity: OrderProduct::class, fetch: "EAGER")]
    #[Groups(['front_orders'])]
    private Collection $OrderProduct;




    public function __construct()
    {
        $this->OrderProduct = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderExtId(): ?string
    {
        return $this->order_ext_id;
    }

    public function setOrderExtId(string $order_ext_id): self
    {
        $this->order_ext_id = $order_ext_id;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, OrderProduct>
     */
    public function getOrderProduct(): Collection
    {
        return $this->OrderProduct;
    }

    public function addOrderProduct(OrderProduct $orderProduct): self
    {
        if (!$this->OrderProduct->contains($orderProduct)) {
            $this->OrderProduct->add($orderProduct);
            $orderProduct->setOrderID($this);
        }

        return $this;
    }

    public function removeOrderProduct(OrderProduct $orderProduct): self
    {
        if ($this->OrderProduct->removeElement($orderProduct)) {
            // set the owning side to null (unless already changed)
            if ($orderProduct->getOrderID() === $this) {
                $orderProduct->setOrderID(null);
            }
        }

        return $this;
    }



}
