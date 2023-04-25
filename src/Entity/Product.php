<?php

namespace App\Entity;

use App\Enum\CurrentCondition;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $ext_id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $width = null;

    #[ORM\Column]
    private ?float $height = null;

    #[ORM\Column]
    private ?float $depth = null;

    #[ORM\Column]
    private ?float $weight = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;


    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'Products')]
    private Collection $categories;

    #[ORM\OneToMany(mappedBy: 'product_id', targetEntity: ProductVariation::class)]
    private Collection $productVariations;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?TaxRule $tax_rule_id = null;



    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->productVariations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExtId(): ?string
    {
        return $this->ext_id;
    }

    public function setExtId(string $ext_id): self
    {
        $this->ext_id = $ext_id;

        return $this;
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


    public function getWidth(): ?float
    {
        return $this->width;
    }

    public function setWidth(float $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(float $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getDepth(): ?float
    {
        return $this->depth;
    }

    public function setDepth(float $depth): self
    {
        $this->depth = $depth;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

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

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $Category): self
    {
        if (!$this->categories->contains($Category)) {
            $this->categories->add($Category);
        }

        return $this;
    }

    public function removeCategory(Category $Category): self
    {
        $this->categories->removeElement($Category);

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
            $productVariation->setProductId($this);
        }

        return $this;
    }

    public function removeProductVariation(ProductVariation $productVariation): self
    {
        if ($this->productVariations->removeElement($productVariation)) {
            // set the owning side to null (unless already changed)
            if ($productVariation->getProductId() === $this) {
                $productVariation->setProductId(null);
            }
        }

        return $this;
    }

    public function getTaxRuleId(): ?TaxRule
    {
        return $this->tax_rule_id;
    }

    public function setTaxRuleId(?TaxRule $tax_rule_id): self
    {
        $this->tax_rule_id = $tax_rule_id;

        return $this;
    }




}
