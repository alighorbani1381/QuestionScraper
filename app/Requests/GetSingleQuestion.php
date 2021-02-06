<?php

namespace App\Requests;


use PhpTool\Vardumper\Debug;
use Src\Services\RequestInterface;
use Src\Services\RequestInitializer;

class GetSingleQuestion extends RequestInitializer implements RequestInterface
{
    public $requestUrl = 'http://hsmai.ir/newpanels/';

    public $requestType = 'http-query';

    public $requestHeader = [

        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',

        'Content-Type' => 'application/x-www-form-urlencoded',

        'Upgrade-Insecure-Requests:' => 1
    ];

    public $requestParameter = [

        'qId' => "Question-ID",

        'action' => "questionViewer",

        'poolId' => "71",

        'retAction' => "115",

        'parentRetAction' => "114"
    ];

    public function __construct($value = null)
    {
        parent::__construct();
        
        $this->rewriteParam('qId', (string)$value);
    }
}
