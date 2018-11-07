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
        header( 'Location: /login');
    }
}