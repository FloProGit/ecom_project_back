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

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductVariation::class)]
    private Collection $productVariations;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?TaxRule $tax_rule = null;

    #[ORM\Column(length: 255)]
    private ?string $ext_reference = null;

    #[ORM\Column]
    private ?bool $has_variation = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $short_description = null;



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
    public function updateCategories(array $newCategories):self
    {
        //get Current Categories
        $currentCategories = $this->getCategories()->toArray();
        $currentCat=[];
        $currentCatListEntity=[];
        foreach ($currentCategories as $currentCategory)
        {
            $code = $currentCategory->getCode();
            $currentCat[]=$code;
            $currentCatListEntity[$code] = $currentCategory;
        }
        //get New Categories
        $newCat=[];
        $newCatListEntity=[];
        foreach ($newCategories as $newCategory)
        {
            $code = $newCategory->getCode();
            $newCat[]=$code;
            $newCatListEntity[$code] = $newCategory;
        }
        //Get with add and remove
       $diffAdd= array_diff($newCat,$currentCat);
       $diffRemove= array_diff($currentCat,$newCat);
       //do action add and remove from ListEntity by code
       foreach ($diffRemove as $toRemove)
       {
           $this->removeCategory($currentCatListEntity[$toRemove]);
       }
        foreach ($diffAdd as $toAdd)
        {
            $this->addCategory($newCatListEntity[$toAdd]);
        }
        return $this;
    }
    public function addMultipleCategory(array $categories): self
    {
       foreach ($categories as $category){
           $this->addCategory($category);
       }
        return $this;
    }
    public function removeCategory(Category $Category): self
    {
        $this->categories->removeElement($Category);

        return $this;
    }
    public function removeMultipleCategory(array $categories): self
    {
        foreach ($categories as $category){
            $this->removeCategory($category);
        }
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
        return $this->tax_rule;
    }

    public function setTaxRuleId(?TaxRule $tax_rule): self
    {
        $this->tax_rule = $tax_rule;

        return $this;
    }

    public function getExtReference(): ?string
    {
        return $this->ext_reference;
    }

    public function setExtReference(string $ext_reference): self
    {
        $this->ext_reference = $ext_reference;

        return $this;
    }

    public function isHasVariation(): ?bool
    {
        return $this->has_variation;
    }

    public function setHasVariation(bool $has_variation): self
    {
        $this->has_variation = $has_variation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->short_description;
    }

    public function setShortDescription(string $short_description): self
    {
        $this->short_description = $short_description;

        return $this;
    }




}
