<?php

namespace Src;

use Exception;
use PhpTool\Vardumper\Debug;

class Applicant
{

    public $curlHandler;

    public $requestPage;

    public $headers;

    public $requestParameter;

    public function __construct(string $requestPage, string $requestType, $customRequestHeaders = null, $requestParameters)
    {
        $this->curlHandler = curl_init();

        $this->setRequestPage($requestPage);

        $this->setRequestType($requestType, $requestParameters);

        $this->headers = HeaderSetter::getHeaders($this->requestParameter, $customRequestHeaders);
    }


    public function setRequestPage(string $url)
    {
        $this->requestPage = $url;
    }

    public function setHttpQuery(array $request)
    {
        $this->requestParameter = http_build_query($request);
    }

    /**
     * set request with json fomrmat
     * 
     * @return void
     */
    public function setJsonRequest(array $request)
    {
        $this->requestParameter = json_encode($request);
    }

    /*
     * settnig types of requests
     *
     * @throws string
     *
     * @return void
     * */
    public function setRequestType($type = '', $requestParameters)
    {
        switch ($type) {

            case 'json':
                $this->setJsonRequest($requestParameters);
                break;

            case 'http-query':
                $this->setHttpQuery($requestParameters);
                break;

            default:
                throw new Exception('Request Type is Invalid Or not Send! ');
                break;
        }
    }


    /**
     * main method send request into special request url
     * with custom headers and custom value request
     * NOTE: in headers ajax request emulatation 
     * 
     * to get result get from request you must call get method after use this method
     */
    public function sendRequest()
    {

        // create temp file store cookie 
        $cookiFile = dirname(__FILE__) . '/../storage/cookie.txt';

        // set url to send request
        curl_setopt($this->curlHandler, CURLOPT_URL, $this->requestPage);

        // set this parameter as a post list
        curl_setopt($this->curlHandler, CURLOPT_POSTFIELDS,  $this->requestParameter);

        //set headers into request
        curl_setopt($this->curlHandler, CURLOPT_HTTPHEADER, $this->headers);

        // set cookie options
        // curl_setopt($this->curlHandler, CURLOPT_COOKIESESSION, TRUE);
        curl_setopt($this->curlHandler, CURLOPT_COOKIEJAR, $cookiFile);

        // receive server response ...
        curl_setopt($this->curlHandler, CURLOPT_RETURNTRANSFER, true);

        // execute (send) request
        $this->response = curl_exec($this->curlHandler);

        // when curl module has error this code stop running code
        $this->checkResponseWithOutError();

        // close connection after get response
        curl_close($this->curlHandler);

        return $this;
    }

    public function getResult()
    {
        return $this->response;
    }

    public function checkResponseWithOutError()
    {

        if (curl_error($this->curlHandler)) {
            die("curl php module dosen't work");
        }
    }
}
