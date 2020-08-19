<?php
namespace App\Controller;

use App\Entities\Product;


class ProductController extends Controller {
    public function generate(){
        try{
            $request = app()->getRequest();

            if (!$request || $request->getMethod() != 'POST'){
                throw new \Exception();
            }

            $entity_manager = app()->getContainer()->get('app.orm')->getEntityManager();

            $product_generator = app()->getContainer()->get('App\Service\ProductGenerator');

            $product_generator->load($entity_manager);

            $data = [
                'status' => 200,
                'success' => "Products created",
            ];

            return $this->response($data);

        }catch (\Exception $e){
            $data = [
                'status' => 405,
                'errors' => "Method Not Allowed",
            ];
            return $this->response($data, 405);
        }
    }

}