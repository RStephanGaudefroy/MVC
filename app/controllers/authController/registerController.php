<?php

namespace app\controllers\authController;

//use \Core\App;
//use \Core\Mail;
use app\models\Users as USER;
use app\core\Validator;

class RegisterController extends \app\core\Controller
{        
    use \app\traits\authTrait;
    
    private $username;
    private $email;
    private $password;
    private $passwordConf;
    private $id;
    private $token;
    private $csrfToken;
    
    /**
     * Intitialize private variable of this class
     */
    public function init() 
    {
        $this->username = htmlspecialchars($_REQUEST['username']); 
        $this->email = htmlspecialchars($_REQUEST['email']); 
        $this->password = htmlspecialchars($_REQUEST['password']); 
        $this->passwordConf = htmlspecialchars($_REQUEST['passwordConf']); 
        $this->csrfToken = $_REQUEST['csrfToken'];
    }

    /**
     * return view Register
     */
    public function index() 
    {        
        $this->generateCsrfToken();
        $this->view( 'auth/register' );
    }

    /**
     * Method for verify data post from form register
     * @return View
     */
    public function postRegister() 
    {
        if ($_POST)
        {
            $this->init();
            $verifCsrf = $this->verifyCsrfToken();
        
            $rules = USER::getRules();

            $array_val = [
                'username'      => $this->username,
                'email'         => $this->email,
                'password'      => $this->password,
                'passwordConf'  => $this->passwordConf
            ];

            $validate = new Validator($array_val, $rules);
            $errors = $validate->validate();
            
            if (!empty($errors)) 
            {
                $this->session->write('errors', $errors);
                header( 'Location: /register');
            }
            else 
            {
                $this->register();
                header( 'Location: /login');
                exit;
            }
        }
        else
        {
            header( 'Location: /register');;
        }
    }

    /**
     * Register user in database
     * Send email content url confirmation account
     * @return View 
     */
    private function register() 
    {
        $hash = password_hash($this->password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(60));
    
        $params = [
            ':username' => $this->username,
            ':email'    => $this->email,
            ':passw'    => $hash,
            ':token'    => $token
        ];
        
        $user = $this->DB->add("INSERT INTO users (username, email, passw, token) VALUES (:username, :email, :passw, :token)", $params);

        $this->sendEmail( "Bonjour, afin d'initialiser votre compte merci de cliquer sur le lien suivant : \n\nhttp://192.168.100.100:8000/register/confirm_token/$user/$token" );

        $this->session->write('success', 'un mail de confirmation à été envoyé pour valider votre compte : '. $message);
    }

    /**
     * Receive link connetion from user
     * @param int $id
     * @param string $token
     * @return View
     */
    public function confirm_token(int $id, string $token) 
    {
        $this->id = $id;
        $this->token = $token;
        
        $verif = $this->validTokenByUser();
        
        $verif == true ? header( 'Location: /home') : header( 'Location: /login');
    }
}