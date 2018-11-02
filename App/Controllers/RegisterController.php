<?php

namespace App\Controllers;

use \Core\App;
use \Core\Mail;
use App\Models\Users as USER;


class RegisterController extends \Core\Controller
{        
    use \User;
    
    private $username;
    private $email;
    private $password;
    private $passwordConf;
    private $id;
    private $token;
    
    /**
     * Intitialize private variable of this class
     */
    public function init() 
    {
        $this->username = htmlspecialchars($_REQUEST['username']); 
        $this->email = htmlspecialchars($_REQUEST['email']); 
        $this->password = htmlspecialchars($_REQUEST['password']); 
        $this->passwordConf = htmlspecialchars($_REQUEST['passwordConf']); 
    }

    /**
     * return view Register
     */
    public function index() 
    {        
        $this->view( 'auth/register' );
    }

    /**
     * call method to verify data post from form register
     */
    public function postRegister() 
    {
        if ($_POST)
        {
            $this->init();
            
            $array_val = [
                'username' => $this->username,
                'email' => $this->email,
                'password' => $this->password,
                'passwordConf' => $this->passwordConf
            ];
            
            //$response = USER::Validate($array_val);
            
            //if (!empty($response))
                //$this->view( 'auth/register', ['errors' => $response ]);

            $this->register();
        }
        else
        {
            $this->view( 'auth/register' );
        }
    }

    /**
     * Register user in database
     * Send email content url confirmation login
     * @return View
     */
    private function register() 
    {
        $hash = password_hash($this->password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(60));
    
        $params = [
            ':username' => $this->username,
            ':email'    => $this->email,
            ':passw' => $hash,
            ':token'    => $token
        ];
        
        $user = App::getDB()->add("INSERT INTO users (username, email, passw, token) VALUES (:username, :email, :passw, :token)", $params);
 
        $message = "Bonjour, afin d'initialiser votre compte merci de cliquer sur le lien suivant : \n\nhttp://192.168.100.100:8000/register/confirm_token/$user/$token";

        echo '<br>'.$message.'</br>'; // pour essai
        
        $mail = new Mail("devphp@mailinator.com", "Confirmation de votre compte", $message);

        $this->view( 'auth/login' );
    }

    /**
     * Receive link connetion from user
     * @return View
     */
    public function confirm_token($id, $token) 
    {
        $this->id = $id;
        $this->token = $token;
        
        $verif = $this->essai();
        
        $verif === true ? $this->view( 'home' ) : $this->view( 'auth/login' );
    }
}
