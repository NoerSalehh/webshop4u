<?php

namespace App\Entity;

use App\Repository\SpecificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SpecificationRepository::class)
 */
class Specification
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
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    /**
     * @ORM\OneToMany(targetEntity=ProductHasSpecification::class, mappedBy="specification")
     */
    private $productHasSpecifications;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return Collection|ProductHasSpecification[]
     */
    public function getProductHasSpecifications(): Collection
    {
        return $this->productHasSpecifications;
    }

    public function addProductHasSpecification(ProductHasSpecification $productHasSpecification): self
    {
        if (!$this->productHasSpecifications->contains($productHasSpecification)) {
            $this->productHasSpecifications[] = $productHasSpecification;
            $productHasSpecification->setSpecification($this);
        }

        return $this;
    }

    public function removeProductHasSpecification(ProductHasSpecification $productHasSpecification): self
    {
        if ($this->productHasSpecifications->removeElement($productHasSpecification)) {
            // set the owning side to null (unless already changed)
            if ($productHasSpecification->getSpecification() === $this) {
                $productHasSpecification->setSpecification(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        $spes = "$this->type, $this->value ";
        return (string) $spes;
    }
}
