<?php

namespace App\Service;

use App\Entities\Product;

class ProductGenerator
{
    public function load($manager)
    {
        for ($i = 1; $i <= 20; $i++) {
            $product = new Product();
            $product->setName('Product ' . $i);
            $product->setPrice(rand(100, 5000));
            $manager->persist($product);
        }

        $manager->flush();
    }
}