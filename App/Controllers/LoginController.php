<?php

namespace App\Controllers;

use \Core\Database as DB;
use App\Models\Users as USER;

class LoginController extends \Core\Controller
{
    private $email;
    private $password;
    
    /**
     * Intitialize private attributes
     */
    public function init() 
    {
        $this->email = htmlspecialchars($_REQUEST['email']); 
        $this->password = htmlspecialchars($_REQUEST['password']); 
    }
    
    /**
     * return view login
     */
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
    

    /**
     * call method to verify data post from form login
     */
    public function postLogin() 
    {
        if ($_POST)
        {
            $this->init();
            
            $array_val = [
                'email' => $this->email,
                'password' => $this->password,
            ];
            
            $response = USER::Validate($array_val);
            
            if (!empty($response))
                $this->view( 'auth/login', ['errors' => $response ]);
        
            $this->login();
        }
        else
        {
            $this->view( 'auth/login' );
        }
    }

    /**
     * verify password and log user else return view login
     */
    private function login()
    {
        $params = [ $this->email ];

        $user = App::getDB()->request( "SELECT * FROM users WHERE email = ?", $params );

        if ( $user && password_verify( $this->password, $user->password ) )
        {
            /* here code session write */
            $this->view( 'home' );
        }
        else
        {
            $this->view( 'auth/login' );
        }
    }
}