<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prodname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img;

    /**
     * @ORM\OneToMany(targetEntity=OrderHasProduct::class, mappedBy="productkey")
     */
    private $orderHasProducts;

    /**
     * @ORM\OneToMany(targetEntity=ProductHasSpecification::class, mappedBy="product")
     */
    private $productHasSpecifications;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="products")
     */
    private $categorie;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    public function __construct()
    {
        $this->orderHasProducts = new ArrayCollection();
        $this->productHasSpecifications = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProdname(): ?string
    {
        return $this->prodname;
    }

    public function setProdname(string $prodname): self
    {
        $this->prodname = $prodname;

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

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): self
    {
        $this->img = $img;

        return $this;
    }

    /**
     * @return Collection|OrderHasProduct[]
     */
    public function getOrderHasProducts(): Collection
    {
        return $this->orderHasProducts;
    }

    public function addOrderHasProduct(OrderHasProduct $orderHasProduct): self
    {
        if (!$this->orderHasProducts->contains($orderHasProduct)) {
            $this->orderHasProducts[] = $orderHasProduct;
            $orderHasProduct->setProductkey($this);
        }

        return $this;
    }

    public function removeOrderHasProduct(OrderHasProduct $orderHasProduct): self
    {
        if ($this->orderHasProducts->removeElement($orderHasProduct)) {
            // set the owning side to null (unless already changed)
            if ($orderHasProduct->getProductkey() === $this) {
                $orderHasProduct->setProductkey(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProductHasSpecification[]
     */
    public function getspecifications(): Collection
    {
        return $this->productHasSpecifications;
    }

    public function addProductHasSpecification(ProductHasSpecification $productHasSpecification): self
    {
        if (!$this->productHasSpecifications->contains($productHasSpecification)) {
            $this->productHasSpecifications[] = $productHasSpecification;
            $productHasSpecification->setProduct($this);
        }

        return $this;
    }

    public function removeProductHasSpecification(ProductHasSpecification $productHasSpecification): self
    {
        if ($this->productHasSpecifications->removeElement($productHasSpecification)) {
            // set the owning side to null (unless already changed)
            if ($productHasSpecification->getProduct() === $this) {
                $productHasSpecification->setProduct(null);
            }
        }

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->prodname;
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
}
