<?php

namespace Src\DOM;

class DomDispatcher
{
    public static function getUsefulInfo($domClass, $param = null)
    {
        $param  = (array) $param;
        
        $domObject = new $domClass(...$param);

        return $domObject->getInfo();
    }
}
