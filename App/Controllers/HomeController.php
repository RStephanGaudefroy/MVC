<?php

namespace App\Controllers;

use \Core\Session;

class HomeController extends \Core\Controller
{
    public function index() 
    {
        $check = $this->session->read('auth');
        
        if ( ($check != null) )
        {
            $this->view( 'auth/login' );
        }
        else 
        {
            $this->view( 'home' );
        }
    }
}