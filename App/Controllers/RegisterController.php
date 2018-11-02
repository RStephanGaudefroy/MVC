<?php

namespace App\Controllers;

use \Core\App;
use \Core\Mail;
use \Core\Auth;
use App\Models\Users as USER;

class RegisterController extends \Core\Controller
{
    private $username;
    private $email;
    private $password;
    private $passwordConf;
    
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
            
            $response = USER::Validate($array_val);
            
            if (!empty($response))
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
    public function register() 
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
 
        $message = "Bonjour, afin d'initialiser votre compte merci de cliquer sur le lien suivant : \n\nhttp://192.168.100.100:8000/register/confirm_token/$user/{$token}";

        echo '<br>'.$message.'</br>'; // pour essai
        
        $mail = new Mail("devphp@mailinator.com", "Confirmation de votre compte", $message);

        $this->view( 'auth/login' );
    }

    /**
     * Test token registration send by mail at user
     * update field token to NULL in database 
     * @return View
     */
    public function confirm_token($id, $token) 
    {
        $user =App::getDB()->request("SELECT * FROM users WHERE id = ?", [$id]);

        if ($user && $user->token == $token)
        {
            $req = App::getDB()->add('UPDATE users SET token = NULL, confirmed_at = NOW() WHERE id = ?', [$user->id]); 
            $auth = new Auth;
            $auth->authLogin('auth', $user->email);
            $this->view( 'home' ); 
            exit();  
        }

        $this->view( 'auth/login' );   
    }
}
