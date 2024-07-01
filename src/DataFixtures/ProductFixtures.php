<?php

declare(strict_types=1);

namespace App\DataFixtures;


use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;

/**
 * Class ProductFixtures.
 */
class ProductFixtures
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getProductData() as $data) {
            $product = new Product();
            $product->setId($data['id']);
            $product->setName($data['name']);
            $product->setDescription($data['description']);
            $product->setPrice($data['price']);
            $product->setCurrency($data['currency']);
            $product->setAmount($data['amount']);

            $manager->persist($product);
        }

        $manager->flush();
    }

    private function getProductData(): \Generator
    {
        yield [
            'id' => 'fbcb8c51-5dcc-4fd4-a4cd-ceb9b400bff7',
            'name' => 'Product A',
            'description' => 'Description A',
            'price' => 10.0,
            'currency' => 'PLN',
            'amount' => 5,
        ];

        yield [
            'id' => '9670ea5b-d940-4593-a2ac-4589be784203',
            'name' => 'Product B',
            'description' => 'Description B',
            'price' => 15.0,
            'currency' => 'EUR',
            'amount' => 10,
        ];

        yield [
            'id' => '15e4a636-ef98-445b-86df-46e1cc0e10b5',
            'name' => 'Product C',
            'description' => 'Description C',
            'price' => 20.0,
            'currency' => 'USD',
            'amount' => 8,
        ];
    }
}