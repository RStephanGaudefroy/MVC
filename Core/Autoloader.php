<?php

class Autoloader
{
    static function autoload($class)
    {
        $directoryMap = [
            'App/Controllers/',
            'App/Models/',
            'Core/'
        ];
        
        $class = str_replace('\\', '/',  $class);
        //echo '<br>new : ' . $class. '.php</br>';
        
        
        if (file_exists( ROOT . 'App/Controllers/' . $class. '.php'))
        {
            require_once (ROOT . 'App/Controllers/' . $class. '.php');
        }

        elseif (file_exists( ROOT . 'Core/' . $class. '.php'))
        {
            require_once (ROOT . 'Core/' . $class. '.php');
        }

        elseif (file_exists( ROOT . 'App/Models/' . $class. '.php'))
        {
            require_once (ROOT . 'App/Models/' . $class. '.php');
        }

        elseif (file_exists( ROOT . 'App/Trait/' . $class. '.php'))
        {
            require_once (ROOT . 'App/Trait/' . $class. '.php');
        }
        

        elseif (file_exists( ROOT . $class. '.php'))
        {            
            require_once (ROOT . $class. '.php');
        }
        
        // die processus application for the moment
        else 
        {
            die ('this file '. $class.' does not exist');
        }
    }
}
