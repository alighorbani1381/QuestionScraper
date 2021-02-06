<?php

namespace App\Requests\Auth;

use Src\Services\RequestInterface;
use Src\Services\RequestInitializer;

class IsLoginRequest extends RequestInitializer implements RequestInterface
{
    public $requestType = 'http-query';

    public $requestUrl = 'http://hsmai.ir/newpanels/';

    public $requestParameter = ["value" => 'test'];
}
