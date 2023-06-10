<?php

namespace App\Entity;

use App\Repository\AttributeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AttributeRepository::class)]
class Attribute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['front_product'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['front_product'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['front_product'])]
    private ?string $value = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\OneToMany(mappedBy: 'attribute', targetEntity: ProductVariation::class)]
    private Collection $productVariations;

    public function __construct()
    {
        $this->productVariations = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
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
