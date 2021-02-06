<?php

namespace Src\Services;

use Src\Applicant;

class RequestInitializer
{
    public $requestUrl;

    public $requestType = 'json';

    public $requestHeader;

    public $requestParameter;

    public function __construct()
    {
        $this->addDependencyHeader('User-Agent', $_SERVER['HTTP_USER_AGENT']);
    }

    public function addDependencyHeader($headerName, $headerValue)
    {
        $this->requestHeader[$headerName] = $headerValue;
    }

    /**
     * Check User is set Custom Header 
     * 
     * @return bool
     */
    public function isSetCustomHeader()
    {
        return (!(is_null($this->requestHeader)));
    }

    public function getCustomHeaders()
    {
        return $this->isSetCustomHeader() ? $this->requestHeader : null;
    }

    public function rewriteParam($key, $value)
    {
        $this->requestParameter[$key] = $value;
    }

    public function get()
    {
        $applicant = new Applicant($this->requestUrl, $this->requestType, $this->getCustomHeaders(), $this->requestParameter);

        return $applicant->sendRequest()->getResult();
    }
}
