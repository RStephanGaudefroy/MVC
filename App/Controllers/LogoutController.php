<?php

namespace App\Controllers;

use \Core\Session;

class LogoutController extends \Core\Controller
{      
    /**
     * Disconnect user
     */
    public function logout()
    {
        Session::delete('auth');
        $this->view( 'auth/login' );
    }
}