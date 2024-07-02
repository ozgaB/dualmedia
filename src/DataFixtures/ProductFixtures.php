<?php

declare(strict_types=1);

namespace App\DataFixtures;


use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class ProductFixtures.
 */
class ProductFixtures extends Fixture
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

            $manager->persist($product);
        }

        $manager->flush();
    }

    private function getProductData(): \Generator
    {
        yield [
            'id' => 1,
            'name' => 'Product A',
            'description' => 'Description A',
            'price' => 10.0,
            'currency' => 'PLN',
        ];

        yield [
            'id' => 2,
            'name' => 'Product B',
            'description' => 'Description B',
            'price' => 15.0,
            'currency' => 'EUR',
        ];

        yield [
            'id' => 3,
            'name' => 'Product C',
            'description' => 'Description C',
            'price' => 20.0,
            'currency' => 'USD',
        ];
    }
}