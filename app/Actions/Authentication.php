<?php

namespace App\Actions;

use Exception;
use Src\StorageFileSaver;
use Src\DOM\DomDispatcher;
use PhpTool\Vardumper\Debug;
use Src\Services\RequestDispatcher;
use App\Requests\Auth\LoginRequest;
use App\Requests\Auth\LogoutRequest;
use App\Requests\Auth\IsLoginRequest;
use App\DomParser\SingleRequestPageParser;

class Authentication
{

    /**
     *  when login is successful this property has a 3 value
     * 
     *  serverDate 
     * 
     *  serverTime
     * 
     *  SID (session id use in request cookie to send another request)
     * 
     *  @var object 
     * */

    public $params;

    public static $instance;

    /**
     * get a singleton instance of class
     * 
     * @return object
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance =  new self();
        }

        return self::$instance;
    }
    
    /**
     * This Method check your client is login in the hsmai site?
     * 
     * @return bool
     */
    public function isLogedin()
    {
        $result = RequestDispatcher::dispatch(IsLoginRequest::class);

        $formExists = DomDispatcher::getUsefulInfo(SingleRequestPageParser::class, $result);

        return !$formExists;
    }

    /**
     * this method logined you at hsmai when dosen't loged in!
     * 
     * @throws string your login rejected
     *  
     * @return void
     */
    public function loginIfDonsentLogin()
    {
        // when login return self object
        if ($this->isLogedin()) {
            $this->logOut();
        }

        $result = RequestDispatcher::dispatch(LoginRequest::class);

        $result = json_decode($result);

        if (!$this->isLoginAccept($result)) {

            throw new Exception('Your Login Request Rejected!');
        }

        $this->params = $result->params;
    }

    /**
     * check value returned of hsmai server is ideal for login
     * 
     * @param object $result (return from hsmai server)
     * 
     * @return bool
     */
    public function isLoginAccept(object $result)
    {
        return (property_exists($result, 'params') && property_exists($result, 'status') && $result->status == 0);
    }

    /**
     * Logout from hsmai panel 
     */
    public function logOut()
    {
        RequestDispatcher::dispatch(LogoutRequest::class);
    }

    public function getParam($key)
    {
        if (property_exists((object)$this->params, $key)) {
            return $this->params->$key;
        }
        return null;
    }

    /**
     * when PHP Language is remove this object from memory
     * logout automatic from hsmai system 
     * 
     * @return void
     */
    public function __destruct()
    {
        $this->logOut();
    }
}
