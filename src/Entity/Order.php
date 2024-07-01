<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Order.
 */
#[ORM\Entity]
#[ORM\Table(name: 'order')]
class Order
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private UuidV4 $id;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank]
    #[Assert\PositiveOrZero]
    private float $priceSummaryGross = 0;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank]
    #[Assert\PositiveOrZero]
    private float $priceSummaryNet = 0;

    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\NotBlank]
    #[Assert\PositiveOrZero]
    private int $productsAmount = 0;

    #[ORM\ManyToMany(targetEntity: Product::class, cascade: ['persist'])]
    #[ORM\JoinTable(name: 'order_products')]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): UuidV4
    {
        return $this->id;
    }

    public function setId(UuidV4 $id): Order
    {
        $this->id = $id;
        return $this;
    }

    public function getPriceSummaryGross(): float
    {
        return $this->priceSummaryGross;
    }

    public function setPriceSummaryGross(float $priceSummaryGross): Order
    {
        $this->priceSummaryGross = $priceSummaryGross;

        return $this;
    }

    public function getPriceSummaryNet(): float
    {
        return $this->priceSummaryNet;
    }

    public function setPriceSummaryNet(float $priceSummaryNet): Order
    {
        $this->priceSummaryNet = $priceSummaryNet;
        return $this;
    }

    public function getProductsAmount(): int
    {
        return $this->productsAmount;
    }

    public function setProductsAmount(int $productsAmount): Order
    {
        $this->productsAmount = $productsAmount;
        return $this;
    }

    /**
     * @return Collection<array-key,Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (false === $this->products->contains($product)) {
            $this->products->add($product);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        $this->products->removeElement($product);

        return $this;
    }
}