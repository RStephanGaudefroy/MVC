<?php

namespace App\Controllers;

class HomeController extends \Core\Controller
{
    public function index() 
    {
        if ( !Auth::authCheck() ) 
        {
            $this->view( 'auth/login' );
        }
        else 
        {
            $this->view( 'home' );
        }     
    }
}