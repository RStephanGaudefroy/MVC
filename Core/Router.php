<?php

namespace Core;

class Router
{
    // Define default controller
    private $controller = 'HomeController';
    
    // Define default method
    private $method = 'index';
    
    // Define default array parameters
    private $params = [];

    // Initialize array content explode url
    private $url = [];

    /**
     * construct controller, method and parameters and call this
     * or call this default
     */
    public function __construct()
    {
        $this->url = $this->getUrl();

        if ( !empty ( $this->url[0] ) ) 
            $this->controller = $this->testFileExist();
          
        if ( isset ( $this->url[1] ) ) 
            $this->method = $this->testMethodExist();
            
        $this->controller = '\\App\\Controllers\\' . $this->controller;
    
        $this->controller = new $this->controller;
        
        $this->params = $this->url ? array_values( $this->url ) : [];
        
        call_user_func_array( [ $this->controller, $this->method ], $this->params);
    }

    /**
     * extract URI from GLOBAL $_SERVER
     * @return array
     */
    private function getUrl() : array
    {
        $uri = ltrim( $_SERVER['REQUEST_URI'], '/' );
        if ( isset( $uri ) )
            return explode( '/', filter_var( rtrim( $uri, '/' ) ) );
    }

    /**
     * test if controller filename exist
     * @return string
     */
    private function testFileExist() 
    {
        if ( file_exists( ROOT . 'App/Controllers/'). ucfirst( $this->url[0] ) . 'Controller.php' ) 
        {
            $controllerName = ucfirst( $this->url[0] ). 'Controller';
            unset( $this->url[0] );
        } 
         
        return $controllerName;
    }

    /**
     * test if method name exist in controller
     * @return string
     */
    private function testMethodExist()
    {
        if ( method_exists( '\\App\\Controllers\\'.$this->controller , $this->url[1] ) ) 
            {
                $method = $this->url[1];
                unset( $this->url[1] );
                return $method;
            }
    }
}