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

    #[ORM\OneToMany(mappedBy: 'condition_product', targetEntity: ProductVariation::class)]
    private Collection $productVariations;

    public function __construct()
    {
        $this->productVariations = new ArrayCollection();
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



    /**
     * @return Collection<int, ProductVariation>
     */
    public function getProductVariations(): Collection
    {
        return $this->productVariations;
    }

    public function addProductVariation(ProductVariation $productVariation): self
    {
        if (!$this->productVariations->contains($productVariation)) {
            $this->productVariations->add($productVariation);
            $productVariation->setConditionProductId($this);
        }

        return $this;
    }

    public function removeProductVariation(ProductVariation $productVariation): self
    {
        if ($this->productVariations->removeElement($productVariation)) {
            // set the owning side to null (unless already changed)
            if ($productVariation->getConditionProductId() === $this) {
                $productVariation->setConditionProductId(null);
            }
        }

        return $this;
    }
}
