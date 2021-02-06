<?php

namespace Src;

use PhpTool\Vardumper\Debug;

class HeaderSetter
{

    public const HEADER_CONFIGURATION_PATH = __DIR__ . '/../config/headers.php';

    /** @var array */
    public $configHeaders;

    /** @var array */
    public $headers = [];


    public function __construct($content, $customHeaders = null)
    {
        $this->configHeaders = require(self::HEADER_CONFIGURATION_PATH);

        $this->configHeaders['Content-Length'] = strlen($content);

        $this->setCustomHeader($customHeaders);

        $this->setCookieHeader();

        $this->makeHeaderFormat();
    }

    public function setCustomHeader($customHeaders)
    {
        foreach ((array)$customHeaders as $headerName => $headerValue) {

            $this->configHeaders[$headerName] = $headerValue;
        }
    }

    /**
     * make headers format string to set hsmai server
     * 
     * @return void
     */
    public function makeHeaderFormat()
    {
        foreach ($this->configHeaders as $headerName => $headerValue) {
            $this->headers[] = "{$headerName}: {$headerValue}";
        }
    }

    /**
     * get all headers to emulate ajax request
     * 
     * @param json $content 
     * 
     * @return array
     */
    public static function getHeaders($content, $customHeaders)
    {
        $headerSetter = new self($content, $customHeaders);

        return $headerSetter->headers;
    }

    public function setCookieHeader()
    {
        $method = CookieGetter::cookieExistsInStorage() ? 'getSessionId' : 'getDefaultId';

        $this->configHeaders['Cookie'] = CookieGetter::$method();
    }
}
