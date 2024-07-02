<?php

declare(strict_types=1);

namespace App\Utils;


use App\Entity\Order;
use App\Entity\Product;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

/**
 * Class OnlyVatProductPriceProvider.
 */
#[AutoconfigureTag('price_provider')]
class OnlyVatProductPriceProvider implements PriceProviderInterface
{
    public function getPrice(Order $order): float
    {
        $price = 0;
        foreach ($order->getOrderProducts() as $orderProduct) {
            $price += (float) bcmul((string) $orderProduct->getProduct()->getPrice(),Product::PRODUCT_VAT,2);
        }

        $order->setPriceSummaryVat($price);
        return $price;
    }
}