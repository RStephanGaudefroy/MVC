<?php

namespace Core;

use \Core\Database;

class App {

    public static $DB;

    public function __construct()
    {
        // Load config file for this application
        require_once (ROOT . 'App/config/Config.php');
        
        // Autoload class
        require_once (ROOT . 'Core/Autoloader.php');
        spl_autoload_register(array('Autoloader', 'autoload'));

        // Session
        //$session = new Session();

        // Call Router 
        $route = new Router;
    }
    
    /**
     * Initialize connection at the Database
     */
    public static function getDB()
    {
        if (self::$DB === null)
        {
            self::$DB = new Database();
        }

        return self::$DB;
    }
    
}