<?php

/**
 * Custom class session
 * use singleton pattern
 */

namespace app\core;

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
    public function write($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Read key - value in $_SESSION
     */
    public function read($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /**
     * Delete key in $_SESSION
     */
    public function delete($key)
    {
        unset($_SESSION[$key]);
    }
}