<?php

namespace App\Entity;

use App\Repository\ProductRepository;
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
    private ?string $category = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $attribute1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $attribute2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $value1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $value2 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $brand = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $feature = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?float $pvp_bigbuy = null;

    #[ORM\Column]
    private ?float $pvd = null;

    #[ORM\Column]
    private ?int $iva = null;

    #[ORM\Column]
    private ?int $video = null;

    #[ORM\Column(length: 255)]
    private ?string $ean13 = null;

    #[ORM\Column]
    private ?float $width = null;

    #[ORM\Column]
    private ?float $height = null;

    #[ORM\Column]
    private ?float $depth = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $image1 = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $image2 = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $image3 = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $image4 = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $image5 = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $image6 = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $image7 = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $image8 = null;

    #[ORM\Column(length: 255)]
    private ?string $condition_state = null;

    #[ORM\Column]
    private ?int $intrastat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getExtId(): ?string
    {
        return $this->ext_id;
    }

    /**
     * @param string|null $ext_id
     */
    public function setExtId(?string $ext_id): self
    {
        $this->ext_id = $ext_id;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

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
        return $this->attribute1;
    }

    public function setAttribute1(?string $attribute1): self
    {
        $this->attribute1 = $attribute1;

        return $this;
    }

    public function getAttribute2(): ?string
    {
        return $this->attribute2;
    }

    public function setAttribute2(?string $attribute2): self
    {
        $this->attribute2 = $attribute2;

        return $this;
    }

    public function getValue1(): ?string
    {
        return $this->value1;
    }

    public function setValue1(?string $value1): self
    {
        $this->value1 = $value1;

        return $this;
    }

    public function getValue2(): ?string
    {
        return $this->value2;
    }

    public function setValue2(?string $value2): self
    {
        $this->value2 = $value2;

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

    public function getPvpBigbuy(): ?float
    {
        return $this->pvp_bigbuy;
    }

    public function setPvpBigbuy(float $pvp_bigbuy): self
    {
        $this->pvp_bigbuy = $pvp_bigbuy;

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

    public function getVideo(): ?int
    {
        return $this->video;
    }

    public function setVideo(int $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getEan13(): ?string
    {
        return $this->ean13;
    }

    public function setEan13(string $ean13): self
    {
        $this->ean13 = $ean13;

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

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

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

    public function getImage1(): ?string
    {
        return $this->image1;
    }

    public function setImage1(?string $image1): self
    {
        $this->image1 = $image1;

        return $this;
    }

    public function getImage2(): ?string
    {
        return $this->image2;
    }

    public function setImage2(?string $image2): self
    {
        $this->image2 = $image2;

        return $this;
    }

    public function getImage3(): ?string
    {
        return $this->image3;
    }

    public function setImage3(?string $image3): self
    {
        $this->image3 = $image3;

        return $this;
    }

    public function getImage4(): ?string
    {
        return $this->image4;
    }

    public function setImage4(?string $image4): self
    {
        $this->image4 = $image4;

        return $this;
    }

    public function getImage5(): ?string
    {
        return $this->image5;
    }

    public function setImage5(?string $image5): self
    {
        $this->image5 = $image5;

        return $this;
    }

    public function getImage6(): ?string
    {
        return $this->image6;
    }

    public function setImage6(?string $image6): self
    {
        $this->image6 = $image6;

        return $this;
    }

    public function getImage7(): ?string
    {
        return $this->image7;
    }

    public function setImage7(?string $image7): self
    {
        $this->image7 = $image7;

        return $this;
    }

    public function getImage8(): ?string
    {
        return $this->image8;
    }

    public function setImage8(?string $image8): self
    {
        $this->image8 = $image8;

        return $this;
    }

    public function getConditionState(): ?string
    {
        return $this->condition_state;
    }

    public function setConditionState(string $condition_state): self
    {
        $this->condition_state = $condition_state;

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
}
