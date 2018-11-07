<?php

namespace app\controllers\authController;


use app\models\Users as USER;
use app\core\Validator;

class ForgotPasswordController extends \app\core\Controller
{
    use \app\traits\authTrait;
    
    private $email;
    private $id;
    private $token;
    
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
        $this->view( 'auth/forgotPassword' );
    }

    /**
     * 
     */
    public function postForgotPassword()
    {
        if ($_POST)
        {
            $this->init();
            
            $rules = USER::getRules();

            $array_val = ['email' => $this->email];
            
            $validate = new Validator($array_val, $rules);
            $errors = $validate->validate();

            if (!empty($errors)) 
            {
                // pass by session for send at view this errors
                header( 'Location: /forgotPassword');
            }
            else
            {
                $params = [ $this->email ];
                $user = App::getDB()->request( "SELECT * FROM users WHERE email = ?", $params );
            
                if ($user)
                    $this->forgotPassword();    
            }
        }
        else
        {
            header( 'Location: /forgotPassword');
        }
    }

    /**
     * 
     */
    private function forgotPassword()
    {
        $token = bin2hex(random_bytes(60));
        $params = ['email'    => $this->email, 'token'    => $token];
        $req = $this->DB->add('UPDATE users SET token = ? WHERE email = ?', [$params]); 

        $message = "Bonjour, afin d'initialiser votre compte merci de cliquer sur le lien suivant : \n\nhttp://192.168.100.100:8000/forgotPassword/confirm_token/{$token}";

        echo '<br>'.$message.'</br>'; // pour essai
        
        //$mail = new Mail("devphp@mailinator.com", "Confirmation de votre compte", $message);

        header( 'Location: /forgotPassword');
        exit;
    }

    /**
     * Receive link connetion from user
     * @return View
     */
    private function confirm_token($id, $token) 
    {
        $this->id = $id;
        $this->token = $token;
        
        $verif = $this->validTokenByUser();
        
        $verif == true ? header( 'Location: /home') : header( 'Location: /login');
    }
}