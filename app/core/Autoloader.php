<?php

class Autoloader
{
    static function autoload($class)
    {
        $class = str_replace('\\', '/',  $class);
        //echo '<br>new : ' . $class. '.php a charger </br>';
        
        if (file_exists( ROOT . $class. '.php'))
        {
            require_once (ROOT . $class. '.php');
            //echo 'chargement '. $class . ' réussie</br>';
        }
        
        // die processus application for the moment
        else 
        {
            die ('<br>this file '. ROOT . $class.' does not exist');
        }
        
    }
}
