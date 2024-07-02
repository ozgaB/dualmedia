<?php

declare(strict_types=1);

namespace App\Tests\Utils;


use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\Product;
use App\Utils\OnlyNetProductPriceProvider;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 * Class OnlyNetProductPriceProviderTest.
 */
class OnlyNetProductPriceProviderTest extends TestCase
{
    /**
     * @dataProvider netPriceProvider
     */
    public function testGetPrice(array $productPrices, float $expectedPrice): void
    {
        $productOrdersArray = [];
        foreach ($productPrices as $productPrice) {
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

        $netProvider = new OnlyNetProductPriceProvider();

        $calculatedNetPrice = $netProvider->getPrice($order);

        $this->assertEquals(round($expectedPrice, 2), round($calculatedNetPrice, 2));
    }

    public function netPriceProvider(): \Generator
    {
        yield [[100.0, 200.0], 231.0];
        yield [[150.0, 250.0], 308.0];
        yield [[99.99, 199.99], 230.98];
        yield [[123.45, 678.90], 617.8];
    }
}