<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;


class IndexController extends Controller {
    public function indexAction(){

        return $this->response([
            'api' => [
                'product/generate' => [
                    'method' => 'POST',
                    'description' => 'Creates 20 random products'
                ],
                'order/create' => [
                    'method' => 'POST',
                    'parameters' => [
                        'products_ids' => ['*', '*', '*']
                    ],
                    'description' => 'Creates an order'
                ],
                'order/pay' => [
                    'method' => 'POST',
                    'parameters' => [
                        'order_id' => '*',
                        'total' => '*'
                    ],
                    'description' => 'Creates an order'
                ]
            ]
        ]);
        
    }
}