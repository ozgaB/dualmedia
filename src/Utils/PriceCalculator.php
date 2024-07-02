<?php

declare(strict_types=1);

namespace App\Utils;


use App\Entity\Order;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

/**
 * Class PriceCalculator.
 */
class PriceCalculator
{
    public function __construct(#[TaggedIterator('price_provider')] private iterable $providers)
    {}

    public function calculate(Order $order): float
    {
        $price = 0;
        foreach ($this->providers as $provider) {
            $price += $provider->getPrice($order);
        }

        $order->setPriceSummaryGross($price);
        return $price;
    }
}