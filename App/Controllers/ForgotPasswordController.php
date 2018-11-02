<?php

namespace App\Controllers;

use \Core\App;
use \Core\Mail;
use App\Models\Users as USER;

class ForgotPasswordController extends \Core\Controller
{
    private $email;
    
    /**
     * Intitialize private variable of this class
     */
    public function init() 
    {
        $this->email = htmlspecialchars($_REQUEST['email']); 
    }

    /**
     * return view Register
     */
    public function index() 
    {        
        $this->view( 'auth/forgotPassword.php' );
    }

    /**
     * 
     */
    public function postForgotPassword()
    {
        if ($_POST)
        {
            $this->init();
            $array_val = ['email' => $this->email];
            
            $response = USER::Validate($array_val);
            if (!empty($response))
                $this->view( 'auth/forgotPassword.php', ['errors' => $response ]);

            $params = [ $this->email ];
            $user = App::getDB()->request( "SELECT * FROM users WHERE email = ?", $params );
            
            if ($user)
                $this->register();
        }
        else
        {
            $this->view( 'auth/forgotPassword.php' );
        }
    }

    /**
     * 
     */
    private function forgotPassword()
    {
        $token = bin2hex(random_bytes(60));
        $params = ['email'    => $this->email, 'token'    => $token];
        $req = App::getDB()->add('UPDATE users SET token = ? WHERE email = ?', [$params]); 

        $message = "Bonjour, afin d'initialiser votre compte merci de cliquer sur le lien suivant : \n\nhttp://192.168.100.100:8000/forgotPassword/confirm_token/{$token}";

        echo '<br>'.$message.'</br>'; // pour essai
        
        $mail = new Mail("devphp@mailinator.com", "Confirmation de votre compte", $message);

        $this->view( 'auth/login' );
        exit;
    }

    /**
     * 
     */
    private function confirm_token($id, $token) 
    {
        /*
        $user =App::getDB()->request("SELECT * FROM users WHERE id = ?", [$id]);

        if ($user && $user->token == $token)
        {
            $req = App::getDB()->add('UPDATE users SET token = NULL, confirmed_at = NOW() WHERE id = ?', [$user->id]); 
            $auth = new Auth;
            $auth->authLogin('auth', $user->email);
            $this->view( 'home' );   
        }
        */

        $this->view( 'auth/login' );   
    }
}