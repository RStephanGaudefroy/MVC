<?php

namespace app\traits;

trait authTrait
{
    /**
     * 
     */
    public function validTokenByUser()
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
     * 
     */
    private function generateCsrfToken()
    {
        if (function_exists('mcrypt_create_iv')) {
            $token = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
        } else {
            $token = bin2hex(openssl_random_pseudo_bytes(32));
        }  
        
        $this->session->write('csrfToken', $token);
    }

    /**
     * 
     */
    private function verifyCsrfToken()
    {
        if ( isset( $this->csrfToken ) && !empty( $this->csrfToken ) ) {
            if (hash_equals( $_SESSION['csrfToken'], $this->csrfToken ) ) {
                return true; 
            } else {
                return false;
            }
        }    
    }
}