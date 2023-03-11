<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $code = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $parent_category = null;

    #[ORM\Column]
    private ?int $root_category = null;

    #[ORM\Column(length: 255,nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255,nullable: true)]
    private ?string $meta_title = null;

    #[ORM\Column(length: 255,nullable: true)]
    private ?string $meta_keywords = null;

    #[ORM\Column(length: 255,nullable: true)]
    private ?string $meta_description = null;

    #[ORM\Column(length: 255)]
    private ?string $url_rewritten = null;

    #[ORM\Column(length: 255,nullable: true)]
    private ?string $image_url = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

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

    public function getParentCategory(): ?string
    {
        return $this->parent_category;
    }

    public function setParentCategory(string $parent_category): self
    {
        $this->parent_category = $parent_category;

        return $this;
    }

    public function getRootCategory(): ?int
    {
        return $this->root_category;
    }

    public function setRootCategory(int $root_category): self
    {
        $this->root_category = $root_category;

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

    public function getMetaTitle(): ?string
    {
        return $this->meta_title;
    }

    public function setMetaTitle(string $meta_title): self
    {
        $this->meta_title = $meta_title;

        return $this;
    }

    public function getMetaKeywords(): ?string
    {
        return $this->meta_keywords;
    }

    public function setMetaKeywords(string $meta_keywords): self
    {
        $this->meta_keywords = $meta_keywords;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->meta_description;
    }

    public function setMetaDescription(string $meta_description): self
    {
        $this->meta_description = $meta_description;

        return $this;
    }

    public function getUrlRewritten(): ?string
    {
        return $this->url_rewritten;
    }

    public function setUrlRewritten(string $url_rewritten): self
    {
        $this->url_rewritten = $url_rewritten;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    public function setImageUrl(string $image_url): self
    {
        $this->image_url = $image_url;

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
}
