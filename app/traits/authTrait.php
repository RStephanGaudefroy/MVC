<?php

namespace app\traits;

use app\core\Mail;

trait authTrait
{
    /**
     * Send email to user
     * @param string $message
     */
    public function sendEmail(string $message)
    {
        $mail = new Mail($this->email, "Confirmation de votre compte", $message);
        
    }
    
    /**
     * Verify token field in DB with token from get user
     * @return bool
     */
    private function validTokenByUser():bool
    {       
        $user =$this->DB->request("SELECT * FROM users WHERE id = ?", [$this->id]);
        //echo $this->token;
        
        if ($user && $user->token == $this->token)
        {
            $req = $this->DB->add('UPDATE users SET token = NULL, confirmed_at = NOW() WHERE id = ?', [$user->id]); 
            $userConnect = $this->DB->request("SELECT * FROM users WHERE id = ?", [$user->id]);
            $this->session->write('auth', $userConnect);
            return true;
        }
        
        return false;
    }

    /**
     * Generate csrf token
     * Write this token in session
     */
    private function generateCsrfToken()
    {
        if (function_exists('mcrypt_create_iv')) {
            $csrf = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
        } else {
            $csrf = bin2hex(openssl_random_pseudo_bytes(32));
        }  
        
        $this->session->write('csrfToken', $csrf);
    }

    /**
     * Verify csrt token from form
     * @return bool
     */
    private function verifyCsrfToken()
    {
        if ( isset( $this->csrfToken ) && !empty( $this->csrfToken ) ) {
            if (hash_equals( $_SESSION['csrfToken'], $this->csrfToken ) ) {
                echo 'csrf ok';
                return true; 
            } else {
                echo 'csrf pas ok';
                return false;
            }
        }    
    }
}