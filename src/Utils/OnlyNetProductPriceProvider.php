<?php

declare(strict_types=1);

namespace App\Utils;


use App\Entity\Order;
use App\Entity\Product;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

/**
 * Class OnlyNetProductPriceProvider.
 */
#[AutoconfigureTag('price_provider')]
class OnlyNetProductPriceProvider implements PriceProviderInterface
{
    public function getPrice(Order $order): float
    {
        $netFactor = bcsub('1',Product::PRODUCT_VAT,2);
        $price = 0;

        foreach ($order->getOrderProducts() as $orderProduct) {
            $price += (float) bcmul((string) $orderProduct->getProduct()->getPrice(),$netFactor,2);
        }

        $order->setPriceSummaryNet($price);
        return $price;
    }
}