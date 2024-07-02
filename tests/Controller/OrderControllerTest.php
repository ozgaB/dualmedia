<?php

declare(strict_types=1);

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OrderControllerTest.
 */
class OrderControllerTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }


    public function testCreate()
    {
        $this->client->request(
            method: 'POST',
            uri: '/order/create',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode([
                'orderProducts' => [
                    [
                        'product' => 1,
                        'quantity' => 21,
                    ],
                    [
                        'product' => 2,
                        'quantity' => 37,
                    ],
                ],
            ])
        );
        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $responseContent = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('priceSummaryGross', $responseContent);
        $this->assertArrayHasKey('priceSummaryNet', $responseContent);
        $this->assertArrayHasKey('productsAmount', $responseContent);
        $this->assertArrayHasKey('priceSummaryVat', $responseContent);
        $this->assertEquals(50.00, $responseContent['priceSummaryGross']);
        $this->assertEquals(38.50, $responseContent['priceSummaryNet']);
        $this->assertEquals(11.50, $responseContent['priceSummaryVat']);
    }

    public function testShow()
    {
        $this->client->request(method: 'GET', uri: sprintf('/order/show/%s',1));

        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $responseContent = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('priceSummaryGross', $responseContent);
        $this->assertArrayHasKey('priceSummaryNet', $responseContent);
        $this->assertArrayHasKey('productsAmount', $responseContent);
        $this->assertArrayHasKey('priceSummaryVat', $responseContent);
        foreach ($responseContent['orderProducts'] as $orderProduct) {
            $this->assertArrayHasKey('product', $orderProduct);
            $this->assertArrayHasKey('quantity', $orderProduct);

            $product = $orderProduct['product'];
            $this->assertArrayHasKey('name', $product);
            $this->assertArrayHasKey('description', $product);
            $this->assertArrayHasKey('price', $product);
            $this->assertArrayHasKey('currency', $product);
        }
    }
}