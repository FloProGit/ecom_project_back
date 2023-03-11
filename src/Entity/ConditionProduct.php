<?php

namespace App\Entity;

use App\Repository\ConditionProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConditionProductRepository::class)]
class ConditionProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $current_condition = null;

    #[ORM\OneToMany(mappedBy: 'condition_product_id', targetEntity: Product::class)]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrentCondition(): ?string
    {
        return $this->current_condition;
    }

    public function setCurrentCondition(string $current_condition): self
    {
        $this->current_condition = $current_condition;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setConditionProductId($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getConditionProductId() === $this) {
                $product->setConditionProductId(null);
            }
        }

        return $this;
    }
}
