<?php

namespace App\Requests\Auth;

use Src\Services\RequestInterface;
use Src\Services\RequestInitializer;

class LoginRequest extends RequestInitializer implements RequestInterface
{
    public $requestUrl = 'http://hsmai.ir/newpanels/?controller=data';

    public $requestType = 'http-query';

    public $requestParameter = [

        'username' => '',

        'password' => '',

        'action' => 'login',

    ];

    public $requestHeader = [

        'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8'

    ];

    public function __construct()
    {
        parent::__construct();

        $authInfo = require('config/auth.php');

        $this->rewriteParam('username', $authInfo['username']);

        $this->rewriteParam('password', $authInfo['password']);
    }
}
