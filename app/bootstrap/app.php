<?php
define("BASE_PATH", dirname(__DIR__));

$app =  \App\System\App::getInstance(BASE_PATH);

return $app;