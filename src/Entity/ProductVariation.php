<?php

namespace App\Entity;

use App\Repository\ProductVariationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Expr\Array_;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductVariationRepository::class)]
class ProductVariation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['front_product'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['front_product'])]
    private ?string $ext_id = null;

    #[ORM\Column]
    #[Groups(['front_product'])]
    private ?int $quantity = null;

    #[ORM\Column]
    #[Groups(['front_product'])]
    private ?int $minimal_quantity = null;

    #[ORM\Column(length: 255)]
    #[Groups(['front_product'])]
    private ?string $ean13 = null;

    #[ORM\Column]
    #[Groups(['front_product'])]
    private ?float $wholesale_price = null;

    #[ORM\Column]
    #[Groups(['front_product'])]
    private ?bool $on_sale = null;

    #[ORM\Column]
    #[Groups(['front_product'])]
    private ?float $price_tax_exclude = null;

    #[ORM\Column(length: 255)]
    #[Groups(['front_product'])]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'productVariations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'productVariations')]
    #[Groups(['front_product'])]
    private ?Manufacter $manufacter = null;

    #[ORM\ManyToOne(inversedBy: 'productVariations')]
    #[Groups(['front_product'])]
    private ?Discount $discount = null;

    #[ORM\OneToMany(mappedBy: 'product_variation', targetEntity: MediaUrl::class)]
    #[Groups(['front_product'])]
    private Collection $mediaUrls;

    #[ORM\Column(length: 255)]
    #[Groups(['front_product'])]
    private ?string $ext_reference = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'productVariations')]
    #[Groups(['front_product'])]
    private ?ConditionProduct $condition_product = null;

    #[ORM\Column]
    private ?bool $is_main = null;

    #[ORM\ManyToOne(inversedBy: 'productVariations')]
    #[Groups(['front_product'])]
    private ?Attribute $attribute = null;

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
        return $this->product;
    }

    public function setProductId(?product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getManufacter(): ?Manufacter
    {
        return $this->manufacter;
    }

    public function setManufacter(?Manufacter $manufacter): self
    {
        $this->manufacter = $manufacter;

        return $this;
    }

    public function getDiscount(): ?Discount
    {
        return $this->discount;
    }

    public function setDiscountId(?Discount $discount): self
    {
        $this->discount = $discount;

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
    public function addMultipleMediaUrl(Array $ArrayMediaUrl): self
    {
        foreach ($ArrayMediaUrl as $media)
        {
            $this->addMediaUrl($media);
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

    public function getExtReference(): ?string
    {
        return $this->ext_reference;
    }

    public function setExtReference(string $ext_reference): self
    {
        $this->ext_reference = $ext_reference;

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

    public function getConditionProduct(): ?ConditionProduct
    {
        return $this->condition_product;
    }

    public function setConditionProductId(?ConditionProduct $condition_product): self
    {
        $this->condition_product = $condition_product;

        return $this;
    }

    public function isIsMain(): ?bool
    {
        return $this->is_main;
    }

    public function setIsMain(bool $is_main): self
    {
        $this->is_main = $is_main;

        return $this;
    }

    public function getAttribute(): ?Attribute
    {
        return $this->attribute;
    }

    public function setAttribute(?Attribute $attribute): self
    {
        $this->attribute = $attribute;

        return $this;
    }
}
