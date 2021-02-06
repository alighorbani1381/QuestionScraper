<?php

namespace Src;

use Exception;

class DependencyChecker
{
    const COMMAND_LINE_INTERFACE = 'CLI';

    /**
     * main method whene run this method checking dependency
     * 
     * if donsn't exists dependency throw an error and stop code!
     * 
     * @throws mixed
     * 
     * @return void
     */
    public static function check()
    {
        $checker = new self;

        $checker->checkPHPSapi();

        $checker->checkCurl();
    }

    /**
     * check sapi run script is not CLI (Command Line)
     * 
     * @throws string 
     */
    private function checkPHPSapi()
    {
        $sapi = php_sapi_name();

        if (strtoupper($sapi) == self::COMMAND_LINE_INTERFACE) {
            throw new Exception("This Application isn't working in command line ");
            die;
        }
    }

    /**
     * Check the CURL php module is exists from this server
     * 
     * @throws
     * 
     * @return void
     */
    private function checkCurl()
    {
        $isExtensionExists = in_array('curl', get_loaded_extensions());

        $isCurlFunExists  = function_exists('curl_version');

        if (!($isCurlFunExists && $isExtensionExists)) {
            throw new Exception("The CURL PHP Module don't exists in your server");
        }
    }
}
