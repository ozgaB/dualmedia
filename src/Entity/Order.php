<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\UuidV4;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Order.
 */
#[ORM\Entity]
#[ORM\Table(name: 'dualmedia_order')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'integer', unique: true)]
    private int $id;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank]
    #[Assert\PositiveOrZero]
    #[Groups(['order-create','order-show'])]
    private float $priceSummaryGross = 0;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank]
    #[Assert\PositiveOrZero]
    #[Groups(['order-create','order-show'])]
    private float $priceSummaryNet = 0;

    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\NotBlank]
    #[Assert\PositiveOrZero]
    #[Groups(['order-create','order-show'])]
    private int $productsAmount = 0;

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: OrderProduct::class, cascade: ['persist', 'remove'])]
    #[Groups(['order-create', 'order-show'])]
    private Collection $orderProducts;

    public function __construct()
    {
        $this->orderProducts = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
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
     * @return Collection<array-key, OrderProduct>
     */
    public function getOrderProducts(): Collection
    {
        return $this->orderProducts;
    }

    public function addOrderProduct(OrderProduct $orderProduct): self
    {
//        foreach ($this->orderProducts as $existingOrderProduct) {
//            if ($existingOrderProduct->getProduct() === $orderProduct->getProduct()) {
//                throw new \Exception('Duplicate product in the order.');
//            }
//        }
        $this->orderProducts->add($orderProduct);
        $orderProduct->setOrder($this);

        return $this;
    }

    public function removeOrderProduct(OrderProduct $orderProduct): self
    {
        $this->orderProducts->removeElement($orderProduct);

        return $this;
    }
}