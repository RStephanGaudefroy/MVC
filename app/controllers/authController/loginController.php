<?php

namespace app\controllers\authController;

use app\models\Users as USER;
use app\core\Validator;
//use app\core\Mail;

class LoginController extends \app\core\Controller
{
    use \app\traits\authTrait;
    
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
     * @return View
     */
    public function index()
    {        
        //echo '<br> ici :'.$view;
        if ( ( $this->session->read('auth') != null ) )
        {
            $this->view( 'home' );
        }
        else 
        {
            $this->generateCsrfToken();
            $this->view( 'auth/login' );
        }
    }
    

    /**
     * call method to verify data post from form login
     * @return View
     */
    public function postLogin() 
    {
        if ($_POST)
        {
            $this->init();
            
            $verifCsrf = $this->verifyCsrfToken();
            if ( !$verifCsrf )
                exit();
            
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
                //header( 'Location: /login');
                $this->redirect( '/login' );
            }
            else 
            {
                $verifyUser = $this->login();
                if ( $verifyUser)
                {
                    $this->redirect( '/home' );
                }
                else 
                {
                    $this->redirect( '/login' );
                }
            }
        }
        else
        {
            $this->redirect( '/login' );
        }
    }

    /**
     * verify password, token and log user
     * @return bool
     */
    private function login():bool
    {
        $params = [ $this->email ];

        $user = $this->DB->request( "SELECT * FROM users WHERE email = ?", $params );

        if ( $user && password_verify( $this->password, $user->passw ) )
        {
            if ( $user->token != null )
            {
                $token = bin2hex(random_bytes(60));
                
                $update = $this->DB->add('UPDATE users SET token = ? WHERE id = ?', [$token, $user->id]); 
                
                $this->sendEmail("Bonjour, afin de valider votre compte merci de cliquer sur le lien suivant : \n\nhttp://192.168.100.100:8000/register/confirm_token/$user->id/$token");
                
                $this->session->write('errors', "Votre compte n'a pas été validé, un nouveau mail de validation vient de vous être envoyé' .$message. '     .");
                
                return false;
            }
            else 
            {
                $this->session->write('auth', $user);
                $this->session->write('success', 'Bonjour, vous êtes maintenant connecté');
                return true;
            }
        }
        else
        {
            $this->session->write('errors', 'Aucun compte ne correspond à cet email');
            return false;
        }
    }
}