<?php

namespace Core;

class Session
{
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }        
    }

    /**
     * Write key - value in $_SESSION
     */
    public function writeSession($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Read key - value in $_SESSION
     */
    public function readSession($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /**
     * Delete key in $_SESSION
     */
    public function deleteSession($key)
    {
        unset($_SESSION[$key]);
    }
}