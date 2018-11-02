<?php

use \Core\App;
use \Core\Session;

trait User
{
    public function essai()
    {       
        $user =App::getDB()->request("SELECT * FROM users WHERE id = ?", [$this->id]);
        echo $this->token;
        
        if ($user && $user->token == $this->token)
        {
            $req = App::getDB()->add('UPDATE users SET token = NULL, confirmed_at = NOW() WHERE id = ?', [$user->id]); 
            $session->write('auth', $user);
            return true;
        }
        return false;
    }
}