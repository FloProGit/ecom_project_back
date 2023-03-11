<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $is_active = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $id_parent = null;

    #[ORM\Column(length: 255)]
    private ?string $parent = null;

    #[ORM\Column]
    private ?int $root_category = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $meta_title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $meta_keyword = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $meta_description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_url = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column]
    private ?int $code = null;

    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'categories')]
    private Collection $Products;

    public function __construct()
    {
        $this->Products = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

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

    public function getIdParent(): ?int
    {
        return $this->id_parent;
    }

    public function setIdParent(int $id_parent): self
    {
        $this->id_parent = $id_parent;

        return $this;
    }

    public function getParent(): ?string
    {
        return $this->parent;
    }

    public function setParent(string $parent): self
    {
        $this->parent = $parent;

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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMetaTitle(): ?string
    {
        return $this->meta_title;
    }

    public function setMetaTitle(?string $meta_title): self
    {
        $this->meta_title = $meta_title;

        return $this;
    }

    public function getMetaKeyword(): ?string
    {
        return $this->meta_keyword;
    }

    public function setMetaKeyword(?string $meta_keyword): self
    {
        $this->meta_keyword = $meta_keyword;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->meta_description;
    }

    public function setMetaDescription(?string $meta_description): self
    {
        $this->meta_description = $meta_description;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    public function setImageUrl(?string $image_url): self
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

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
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

    /**
     * @return Collection<int, Product>
     */
    public function getCategoriesId(): Collection
    {
        return $this->Products;
    }

    public function addCategoriesId(Product $categoriesId): self
    {
        if (!$this->Products->contains($categoriesId)) {
            $this->Products->add($categoriesId);
            $categoriesId->addCategory($this);
        }

        return $this;
    }

    public function removeCategoriesId(Product $categoriesId): self
    {
        if ($this->Products->removeElement($categoriesId)) {
            $categoriesId->removeCategory($this);
        }

        return $this;
    }


}
