<?php

namespace Core;

class Controller
{
    public function __construct()
    {
        echo 'bonjour controller<br>';
    }

    /**
     * call files view in folder Views
     */
    protected function view( string $view, array $data = [] )
    {
        require_once ROOT . 'App/Views/' . $view . '.php';
        
    }
}