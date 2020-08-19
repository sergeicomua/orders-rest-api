<?php

namespace App\System\Controller;

interface IController{

    public function response($data, $status = 200, $headers = []);

}