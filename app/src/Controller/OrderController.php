<?php
namespace App\Controller;

class OrderController extends Controller {
    public function create(){
        try{
            $request = app()->getRequest();
            $request = $this->transformJsonBody($request);

            if (!$request || $request->getMethod() != 'POST' || !$request->get('products_ids')){
                throw new \Exception();
            }

            $product_ids = $request->get('products_ids');

            $user_id = 1;

            $entity_manager = app()->getContainer()->get('app.orm')->getEntityManager();

            $order_management = app()->getContainer()->get('App\Service\OrderManagement');

            $order_id = $order_management->create($entity_manager, $product_ids, $user_id);

            if ($order_id){
                $data = [
                    'order_id' => $order_id,
                    'success' => "Order created",
                ];
            }
            else throw new \Exception();

            return $this->response($data);

        }catch (\Exception $e){
            $data = [
                'errors' => "Method Not Allowed",
            ];
            return $this->response($data, 405);
        }
    }

    public function pay(){
        try{
            $request = app()->getRequest();
            $request = $this->transformJsonBody($request);

            if (!$request || $request->getMethod() != 'POST' || !$request->get('order_id') || !$request->get('total')){
                throw new \Exception();
            }

            $order_id =  $request->get('order_id');
            $total =  $request->get('total');

            $entity_manager = app()->getContainer()->get('app.orm')->getEntityManager();

            $order_payment = app()->getContainer()->get('App\Service\OrderPayment');

            $result = $order_payment->pay($entity_manager, $order_id, $total);


            if ($result){
                $data = [
                    'order_id' => $order_id,
                    'success' => "Order has been paid",
                ];
            }
            else throw new \Exception();

            return $this->response($data);

        }catch (\Exception $e){
            $data = [
                'errors' => "Failed to pay for the order",
            ];
            return $this->response($data, 405);
        }
    }
}