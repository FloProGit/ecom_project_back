<?php

namespace App\Entity;

use App\Repository\MediaUrlRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MediaUrlRepository::class)]
class MediaUrl
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 500)]
    private ?string $url_link = null;

    #[ORM\Column(length: 255)]
    private ?string $mime_type = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'mediaUrls')]
    private ?ProductVariation $product_variation = null;

    #[ORM\Column]
    private ?bool $is_main = null;

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

    public function getUrlLink(): ?string
    {
        return $this->url_link;
    }

    public function setUrlLink(string $url_link): self
    {
        $this->url_link = $url_link;

        return $this;
    }

    public function getMimeType(): ?string
    {
        return $this->mime_type;
    }

    public function setMimeType(string $mime_type): self
    {
        $this->mime_type = $mime_type;

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

    public function getProductVariationId(): ?ProductVariation
    {
        return $this->product_variation;
    }

    public function setProductVariationId(?ProductVariation $product_variation): self
    {
        $this->product_variation = $product_variation;

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
}
