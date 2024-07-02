<?php

declare(strict_types=1);

namespace App\Tests\Utils;


use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\Product;
use App\Utils\OnlyVatProductPriceProvider;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 * Class OnlyVatProductPriceProviderTest.
 */
class OnlyVatProductPriceProviderTest extends TestCase
{

    /**
     * @dataProvider vatPriceProvider
     */
    public function testGetPrice(array $productOrders, float $expectedPrice): void
    {
        $productOrdersArray = [];
        foreach ($productOrders as $productPrice) {
            $product = $this->createMock(Product::class);
            $product
                ->expects($this->once())
                ->method('getPrice')
                ->willReturn($productPrice);

            $productOrder = $this->createMock(OrderProduct::class);
            $productOrder
                ->expects($this->once())
                ->method('getProduct')
                ->willReturn($product);

            $productOrdersArray[] = $productOrder;
        }

        $order = $this->createMock(Order::class);
        $order->expects($this->once())
            ->method('getOrderProducts')
            ->willReturn(new ArrayCollection($productOrdersArray));

        $vatProvider = new OnlyVatProductPriceProvider();

        $calculatedVatPrice = $vatProvider->getPrice($order);
        $this->assertEquals(round($expectedPrice, 2), round($calculatedVatPrice, 2));
    }

    public function vatPriceProvider(): \Generator
    {
        yield [[100.0, 200.0], 69.0];
        yield [[150.0, 250.0], 92.0];
        yield [[99.99, 199.99], 68.98];
        yield [[123.45, 678.90], 184.53];
    }
}