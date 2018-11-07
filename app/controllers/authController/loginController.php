<?php

namespace app\controllers\authController;

use app\models\Users as USER;
use app\core\Validator;

class LoginController extends \app\core\Controller
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
        echo '<br> ici :'.$view;
        if ( ( $this->session->read('auth') != null ) )
        {
            $this->view( 'home' );
        }
        else 
        {
            $this->view( 'auth/login' );
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

            $rules = USER::getRules();
            
            $array_val = [
                'email' => $this->email,
                'password' => $this->password,
            ];
            
            $validate = new Validator($array_val, $rules);
            $errors = $validate->validate();
            
            if (!empty($errors)) 
            {
                $this->session->write('errors', $errors);
                header( 'Location: /login');
            }
            else 
            {
                $verifyUser = $this->login();
                if ( $verifyUser)
                {
                    $this->session->write('success', 'Bonjour, vous êtes maintenant connecté');
                    header( 'Location: /home');
                }
                else 
                {
                    $this->session->write('errors', 'Aucun compte ne correspond à cet email');
                    header( 'Location: /login');
                }
            }
        }
        else
        {
            header( 'Location: /login');
        }
    }

    /**
     * verify password and log user else return view login
     */
    private function login()
    {
        $params = [ $this->email ];

        $user = $this->DB->request( "SELECT * FROM users WHERE email = ?", $params );

        if ( $user && password_verify( $this->password, $user->passw ) )
        {
            $this->session->write('auth', $user);
            return true;
        }
        else
        {
            return false;
        }
    }
}