<?php

namespace App\Entity;

use App\Repository\OrderHasProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderHasProductRepository::class)
 */
class OrderHasProduct
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="orderHasProducts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderkey;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="orderHasProducts", cascade={"persist"})

     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $productkey;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderkey(): ?Order
    {
        return $this->orderkey;
    }

    public function setOrderkey(?Order $orderkey): self
    {
        $this->orderkey = $orderkey;

        return $this;
    }

    public function getProductkey(): ?Product
    {
        return $this->productkey;
    }

    public function setProductkey(?Product $productkey): self
    {
        $this->productkey = $productkey;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}
