<?php
namespace  App\Controller;

use App\System\Controller\IController;
use Symfony\Component\HttpFoundation\JsonResponse;


abstract class Controller implements IController
{

    public function response($data, $status = 200, $headers = [])
    {
        return new JsonResponse($data, $status, $headers);
    }


    protected function transformJsonBody(\Symfony\Component\HttpFoundation\Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }

}