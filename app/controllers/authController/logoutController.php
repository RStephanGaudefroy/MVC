<?php

namespace app\controllers\authController;

class LogoutController extends \app\core\Controller
{      
    /**
     * Disconnect user
     */
    public function index()
    {
        $this->session->delete('auth');
        $this->redirect( '/login' );
        //header( 'Location: /login');
    }
}