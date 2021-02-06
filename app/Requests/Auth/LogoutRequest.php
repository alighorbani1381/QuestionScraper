<?php

namespace App\Requests\Auth;

use Src\Services\RequestInterface;
use Src\Services\RequestInitializer;

class LogoutRequest extends RequestInitializer implements RequestInterface
{
    public $requestType = 'http-query';

    public $requestUrl = 'http://hsmai.ir/newpanels/';

    public $requestHeader = [

        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',

        'Content-Type' => 'application/x-www-form-urlencoded',

        'Upgrade-Insecure-Requests:' => 1
    ];

    public $requestParameter = ["action" => 'logout', 'retAction' => 'desktop'];
}
