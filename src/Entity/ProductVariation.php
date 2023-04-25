<?php

namespace App\Entity;

use App\Repository\ProductVariationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductVariationRepository::class)]
class ProductVariation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $ext_id = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?int $minimal_quantity = null;

    #[ORM\Column(length: 255)]
    private ?string $ean13 = null;

    #[ORM\Column]
    private ?float $wholesale_price = null;

    #[ORM\Column]
    private ?bool $on_sale = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price_tax_exclude = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'productVariations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?product $product_id = null;

    #[ORM\ManyToOne(inversedBy: 'productVariations')]
    private ?manufacter $manufacter_id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?discount $discount_id = null;

    #[ORM\OneToMany(mappedBy: 'product_variation_id', targetEntity: MediaUrl::class)]
    private Collection $mediaUrls;

    public function __construct()
    {
        $this->mediaUrls = new ArrayCollection();
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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getMinimalQuantity(): ?int
    {
        return $this->minimal_quantity;
    }

    public function setMinimalQuantity(int $minimal_quantity): self
    {
        $this->minimal_quantity = $minimal_quantity;

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

    public function getWholesalePrice(): ?float
    {
        return $this->wholesale_price;
    }

    public function setWholesalePrice(float $wholesale_price): self
    {
        $this->wholesale_price = $wholesale_price;

        return $this;
    }

    public function isOnSale(): ?bool
    {
        return $this->on_sale;
    }

    public function setOnSale(bool $on_sale): self
    {
        $this->on_sale = $on_sale;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPriceTaxExclude(): ?float
    {
        return $this->price_tax_exclude;
    }

    public function setPriceTaxExclude(float $price_tax_exclude): self
    {
        $this->price_tax_exclude = $price_tax_exclude;

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

    public function getProductId(): ?product
    {
        return $this->product_id;
    }

    public function setProductId(?product $product_id): self
    {
        $this->product_id = $product_id;

        return $this;
    }

    public function getManufacterId(): ?manufacter
    {
        return $this->manufacter_id;
    }

    public function setManufacterId(?manufacter $manufacter_id): self
    {
        $this->manufacter_id = $manufacter_id;

        return $this;
    }

    public function getDiscountId(): ?discount
    {
        return $this->discount_id;
    }

    public function setDiscountId(?discount $discount_id): self
    {
        $this->discount_id = $discount_id;

        return $this;
    }

    /**
     * @return Collection<int, MediaUrl>
     */
    public function getMediaUrls(): Collection
    {
        return $this->mediaUrls;
    }

    public function addMediaUrl(MediaUrl $mediaUrl): self
    {
        if (!$this->mediaUrls->contains($mediaUrl)) {
            $this->mediaUrls->add($mediaUrl);
            $mediaUrl->setProductVariationId($this);
        }

        return $this;
    }

    public function removeMediaUrl(MediaUrl $mediaUrl): self
    {
        if ($this->mediaUrls->removeElement($mediaUrl)) {
            // set the owning side to null (unless already changed)
            if ($mediaUrl->getProductVariationId() === $this) {
                $mediaUrl->setProductVariationId(null);
            }
        }

        return $this;
    }
}
