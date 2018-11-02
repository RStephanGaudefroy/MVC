<?php

namespace Core;

use \Core\Session;

class Controller
{
    public $session;

    public function __construct()
    {
        echo 'bonjour controller<br>';
        $this->session = new Session;
    }

    /**
     * call files view in folder Views
     */
    protected function view( string $view, array $data = [] )
    {
        require_once ROOT . 'App/Views/' . $view . '.php';
        
    }
}