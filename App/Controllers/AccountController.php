<?php

namespace App\Controllers;

class AccountController extends \Core\Controller
{
    public function index() 
    {
        if ( !Auth::authCheck() ) 
        {
            $this->view( 'auth/account' );
        }
        else 
        {
            $this->view( 'login' );
        }     
    }
}