<?php

namespace Src;

class CookieGetter
{
    const INDEX_OF_SESSION_ID = 1;

    const COOKIE_DATA_PATH = __DIR__ . '/../storage/cookie.txt';

    public static function cookieExistsInStorage()
    {
        return file_exists(self::COOKIE_DATA_PATH) && ('JSESSIONID=' != self::getSessionId());
    }

    public static function getSessionId()
    {
        $value = @explode("JSESSIONID", file_get_contents(self::COOKIE_DATA_PATH));

        $sessionId = @trim(rtrim($value[self::INDEX_OF_SESSION_ID]));

        return self::getSessionIdFormat($sessionId);
    }

    public static function canUseAuthCookie()
    {
        return isset($GLOBALS['auth']->params) && property_exists($GLOBALS['auth']->params, 'SID');
    }

    public static function getDefaultId()
    {
        return self::getSessionIdFormat('AAB8A91375AE23161057228BF8D38D87');
    }

    public static function getSessionIdFormat($value)
    {
        return 'JSESSIONID=' . $value;
    }
}
