<?php

declare(strict_types=1);

namespace App\Tests\Utils;


use App\Entity\Order;
use App\Utils\PriceCalculator;
use App\Utils\PriceProviderInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class PriceCalculatorTest.
 */
class PriceCalculatorTest extends TestCase
{
    /**
     * @dataProvider priceCalculatorProvider
     */
    public function testCalculate(array $providerPrices, float $expectedPrice)
    {
        $order = $this->createMock(Order::class);

        $providers = [];
        foreach ($providerPrices as $price) {
            $provider = $this->createMock(PriceProviderInterface::class);
            $provider
                ->method('getPrice')
                ->with($order)
                ->willReturn($price);
            $providers[] = $provider;
        }

        $priceCalculator = new PriceCalculator($providers);
        $calculatedPrice = $priceCalculator->calculate($order);
        $this->assertEquals($expectedPrice, $calculatedPrice);
    }

    public function priceCalculatorProvider(): \Generator
    {
        yield [[100.0, 200.0], 300.0];
        yield [[150.0, 250.0, 50.0], 450.0];
        yield [[99.99, 199.99], 299.98];
        yield [[123.45, 678.90, 100.0], 902.35];
    }
}