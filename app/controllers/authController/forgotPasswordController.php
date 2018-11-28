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
     * @return View
     */
    public function index() 
    {        
        $this->generateCsrfToken();
        $this->view( 'auth/forgotPassword' );
    }

    /**
     * Method for verify data post from form forgotPassword
     * @return View 
     */
    public function postForgotPassword()
    {
        if ($_POST)
        {
            $this->init();
            $verifCsrf = $this->verifyCsrfToken();
            
            $rules = USER::getRules();

            $array_val = ['email' => $this->email];
            
            $validate = new Validator($array_val, $rules);
            $errors = $validate->validate();

            if (!empty($errors)) 
            {
                $this->session->write('errors', $errors);
                $this->redirect( '/forgotPassword' );
                //header( 'Location: /forgotPassword');
            }
            else
            {
                $params = [ $this->email ];
                $user = App::getDB()->request( "SELECT * FROM users WHERE email = ?", $params );
            
                if ($user) 
                {
                    $this->forgotPassword();   
                }
                else 
                {
                    $this->session->write('errors', 'Aucun compte ne correspond à cet email');
                    //header( 'Location: /forgotPassword');
                    $this->redirect( '/forgotPassword' );   
                }
            }
        }
        else
        {
            //header( 'Location: /forgotPassword');
            $this->redirect( '/forgotPassword' );
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

        $message = "Bonjour, afin de reinitialiser votre compte merci de cliquer sur le lien suivant : \n\nhttp://192.168.100.100:8000/forgotPassword/confirm_token/{$token}";

        $this->sendEmail($message);

        //header( 'Location: /forgotPassword');
        $this->redirect( '/forgotPassword' );
        //exit;
    }

    /**
     * Receive link connetion from user
     * And validate csrf token
     * @return View
     */
    private function confirm_token(string $token) 
    {
        $this->token = $token;
        
        $verif = $this->validTokenByUser();
        
        $verif == true ? $this->redirect( '/home' ) : $this->redirect( '/login' );
    }
}