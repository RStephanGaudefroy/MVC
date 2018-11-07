<?php

namespace app\core;

class Controller 
{
    public $session;
    public $DB;

    /**
     * 
     */
    public function __construct()
    {
        $this->session = new Session;
        
        if ($this->DB === null)
            $this->DB = new Database();
    }  
  
  
    /**
     * 
     */
    protected function view( string $view, array $data = [] ) {
        
        require ROOT . 'app/views/' . $view . '.php';
    }
}
