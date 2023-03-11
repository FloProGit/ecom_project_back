<?php

namespace App\Entity;

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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $attribute_1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $attribute_2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $value_1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $value_2 = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $brand = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $feature = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?float $pvp = null;

    #[ORM\Column]
    private ?float $pvd = null;

    #[ORM\Column]
    private ?int $iva = null;

    #[ORM\Column(length: 255)]
    private ?string $video = null;

    #[ORM\Column]
    private ?int $earn13 = null;

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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_5 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_6 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_7 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_8 = null;

    #[ORM\Column]
    private ?int $intrastat = null;

    #[ORM\ManyToMany(targetEntity: category::class, inversedBy: 'Products')]
    private Collection $categories;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?conditionproduct $condition_product_id = null;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
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

    public function getAttribute1(): ?string
    {
        return $this->attribute_1;
    }

    public function setAttribute1(?string $attribute_1): self
    {
        $this->attribute_1 = $attribute_1;

        return $this;
    }

    public function getAttribute2(): ?string
    {
        return $this->attribute_2;
    }

    public function setAttribute2(?string $attribute_2): self
    {
        $this->attribute_2 = $attribute_2;

        return $this;
    }

    public function getValue1(): ?string
    {
        return $this->value_1;
    }

    public function setValue1(?string $value_1): self
    {
        $this->value_1 = $value_1;

        return $this;
    }

    public function getValue2(): ?string
    {
        return $this->value_2;
    }

    public function setValue2(?string $value_2): self
    {
        $this->value_2 = $value_2;

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

    public function getBrand(): ?int
    {
        return $this->brand;
    }

    public function setBrand(int $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getFeature(): ?string
    {
        return $this->feature;
    }

    public function setFeature(?string $feature): self
    {
        $this->feature = $feature;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPvp(): ?int
    {
        return $this->pvp;
    }

    public function setPvp(int $pvp): self
    {
        $this->pvp = $pvp;

        return $this;
    }

    public function getPvd(): ?float
    {
        return $this->pvd;
    }

    public function setPvd(float $pvd): self
    {
        $this->pvd = $pvd;

        return $this;
    }

    public function getIva(): ?int
    {
        return $this->iva;
    }

    public function setIva(int $iva): self
    {
        $this->iva = $iva;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(string $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getEarn13(): ?int
    {
        return $this->earn13;
    }

    public function setEarn13(int $earn13): self
    {
        $this->earn13 = $earn13;

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

    public function getImage1(): ?string
    {
        return $this->image_1;
    }

    public function setImage1(?string $image_1): self
    {
        $this->image_1 = $image_1;

        return $this;
    }

    public function getImage2(): ?string
    {
        return $this->image_2;
    }

    public function setImage2(?string $image_2): self
    {
        $this->image_2 = $image_2;

        return $this;
    }

    public function getImage3(): ?string
    {
        return $this->image_3;
    }

    public function setImage3(?string $image_3): self
    {
        $this->image_3 = $image_3;

        return $this;
    }

    public function getImage4(): ?string
    {
        return $this->image_4;
    }

    public function setImage4(?string $image_4): self
    {
        $this->image_4 = $image_4;

        return $this;
    }

    public function getImage5(): ?string
    {
        return $this->image_5;
    }

    public function setImage5(?string $image_5): self
    {
        $this->image_5 = $image_5;

        return $this;
    }

    public function getImage6(): ?string
    {
        return $this->image_6;
    }

    public function setImage6(?string $image_6): self
    {
        $this->image_6 = $image_6;

        return $this;
    }

    public function getImage7(): ?string
    {
        return $this->image_7;
    }

    public function setImage7(?string $image_7): self
    {
        $this->image_7 = $image_7;

        return $this;
    }

    public function getImage8(): ?string
    {
        return $this->image_8;
    }

    public function setImage8(?string $image_8): self
    {
        $this->image_8 = $image_8;

        return $this;
    }

    public function getIntrastat(): ?int
    {
        return $this->intrastat;
    }

    public function setIntrastat(int $intrastat): self
    {
        $this->intrastat = $intrastat;

        return $this;
    }

    /**
     * @return Collection<int, category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getConditionProductId(): ?conditionproduct
    {
        return $this->condition_product_id;
    }

    public function setConditionProductId(?conditionproduct $condition_product_id): self
    {
        $this->condition_product_id = $condition_product_id;

        return $this;
    }
}
