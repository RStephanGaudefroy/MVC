<?php

namespace app\core;

class Router
{
    private $controller = 'home';
    private $method = 'index';
    private $params = [];
    
    private $maps = [
        //'home' => 'home',
        'register' => 'authController', 
        'login'=> 'authController', 
        'forgotPassword'=> 'authController',
        'logout' => 'authController'
    ];
    private $directory = '';

    /**
     * 
     */
    public function __construct() 
    {
        $route = $this->getParams();
        
        foreach ( $this->maps as $key => $value )
        {
            if ($route[0] === $key)
            {
                echo '<br>'. $key . $value.'<br>';
                    $this->directory = $value . '/';
            }
        }
        
        //echo '<br>le repertoire : '. $this->directory;
        //echo  '<br>' .ROOT . 'app/controllers/' . $this->directory . $route[0] . 'Controller.php';
        
        if ( file_exists( ROOT . 'app/controllers/' . $this->directory . $route[0] . 'Controller.php' ) ) {
            $this->controller = $this->directory . $route[0];
            unset ( $route[0] );
        }
        
        $this->controller = str_replace( '/',  '\\', 'app/controllers/' . $this->controller . 'Controller' );

        //require_once ROOT . 'app/controllers/' . $this->controller . '.php';
        
        if ( isset ( $route[1] ) ) {
            if ( method_exists( $this->controller, $route[1] ) ) {
                $this->method = $route[1];
                unset( $route[1] );
            }
        }

        //echo '<br>method : '. $this->method.'<br>';
        //echo  '<br>controller : '.$this->controller.'</br>';
        $this->controller = new $this->controller;
    
        $this->params = $route ? array_values( $route ) : [];
    
        call_user_func_array( [ $this->controller, $this->method ], $this->params );
    }
      
    
    /**
     * 
     */  
    private function getParams() 
    {
        //echo '<pre>';
        //print_r($_SERVER);

        if ( isset( $_SERVER['REQUEST_URI'] ) )
        {
            $uri = explode( '/', filter_var( rtrim( $_SERVER['REQUEST_URI'], '/' ), FILTER_SANITIZE_URL ) );
            //var_dump( $uri );
            //echo count( $uri );
            if ( count( $uri ) > 1 && $uri[0] == '' )
                $uri = array_slice( $uri, 1 );

            //var_dump($uri);
            return $uri;
        }
    }
}