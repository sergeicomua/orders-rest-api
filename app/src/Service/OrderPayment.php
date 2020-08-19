<?php

namespace App\Service;

use GuzzleHttp;
use App\Entities\Order;

class OrderPayment
{
    public function pay($manager, $order_id, $total)
    {
        $total_order = $manager->getRepository(Order::class)->getTotalOrder($order_id);
        $order = $manager->getRepository(Order::class)->find($order_id);
        if ($order->getStatus() == 1 && $total_order == $total){
            $client = new GuzzleHttp\Client(['curl' => [CURLOPT_SSL_VERIFYPEER => false]]);
            $response = $client->get('https://ya.ru');
            if ($response->getStatusCode() == 200){
                $order->setStatus(2);
                $manager->persist($order);
                $manager->flush();

                return true;
            }
        }

        return false;

    }
}