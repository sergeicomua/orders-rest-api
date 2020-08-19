<?php

namespace App\Service;

use App\Entities\Product;
use App\Entities\Order;
use App\Entities\OrderDetail;

class OrderManagement
{
    public function create($manager, $products_ids, $user_id)
    {

        $products = $manager->getRepository(Product::class)->findAllByIds($products_ids);

        if (!empty($products) && !empty($user_id)){
            $order = new Order();
            $order->setUserId($user_id);
            $order->setStatus(1);
            $manager->persist($order);
            $manager->flush();
            $order_id = $order->getId();

            foreach ($products as $product){
                $order_detail = new OrderDetail();
                $order_detail->setOrderId($order_id);
                $order_detail->setProductId($product['id']);
                $order_detail->setPrice($product['price']);
                $manager->persist($order_detail);
            }

            $manager->flush();

            return $order_id;
        }

        return false;

    }
}