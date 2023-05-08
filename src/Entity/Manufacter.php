<?php

namespace App\Entity;

use App\Repository\ManufacterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ManufacterRepository::class)]
class Manufacter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'manufacter', targetEntity: ProductVariation::class)]
    private Collection $productVariations;

    #[ORM\Column]
    private ?int $ext_id = null;

    public function __construct()
    {
        $this->products = new ArrayCollection();
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
            $productVariation->setManufacterId($this);
        }

        return $this;
    }

    public function removeProductVariation(ProductVariation $productVariation): self
    {
        if ($this->productVariations->removeElement($productVariation)) {
            // set the owning side to null (unless already changed)
            if ($productVariation->getManufacterId() === $this) {
                $productVariation->setManufacterId(null);
            }
        }

        return $this;
    }

    public function getExtId(): ?int
    {
        return $this->ext_id;
    }

    public function setExtId(int $ext_id): self
    {
        $this->ext_id = $ext_id;

        return $this;
    }


}
