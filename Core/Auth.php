<?php

namespace Core;

use \Core\Session;

class Auth
{
    private $session;
    
    public function __construct()
    {
        $session = new Session;
        $this->session = $session;
    }

    public static function authCheck()
    {
        return empty( self::$session->readSession('auth') ) ? true : false;
        
    }
    
    public function authLogin($key, $value)
    {
        $this->session->writeSession($key, $value);
    }
}