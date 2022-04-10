<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    private const MAX_PRODUCT_NUMBER = 10;
    private const PRODUCT_NAME_PREFIX = 'product name ';
    private const PRODUCT_SLUG_PREFIX = 'product-name-';

    public function load(ObjectManager $manager): void
    {

        for ($i = 1; $i <= self::MAX_PRODUCT_NUMBER; ++$i) {
            $product = (new Product())
                ->setName(self::PRODUCT_NAME_PREFIX . $i)
                ->setSlug(self::PRODUCT_SLUG_PREFIX . $i)
                ->setPrice(round(rand(min: 100, max: 10000) / rand(min: 10, max: 20), 2))
                ->setStock(rand(min: 1, max: 20));

            $manager->persist($product);
        }


        $manager->flush();
    }
}
