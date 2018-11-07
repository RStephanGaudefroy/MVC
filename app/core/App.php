<?php

namespace app\core;

class App {

    public function __construct()
    {
          // Load config file for this application
          require_once (ROOT . 'app/config/Config.php');

          // Call Router 
          $route = new Router;
    }
}