<?php

namespace Src\Services;

use PhpTool\Vardumper\Debug;

class RequestDispatcher
{
    public static function dispatch($serviceClass, $param = null)
    {
        $requestObject = is_array($param) ? (new $serviceClass(...$param)) : (new $serviceClass);

        return $requestObject->get();
    }
}
