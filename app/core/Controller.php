<?php

namespace app\core;

class Controller 
{
    public $session;
    public $DB;

    /**
     * 
     */
    public function __construct()
    {
        $this->session = new Session;
        
        if ($this->DB === null)
            $this->DB = new Database();
    }  
  
    /**
     * HTTP redirect
     * @param string $url URL redirect to
     */
    public function redirect($url)
    {        
        // Absolute url
        if ( preg_match( "#^http[s]?://.+#", $url ) )
        {
            http_redirect($url);
        }
        // Relative url ( same domain )
        else 
        {
            if ( function_exists( "http_redirect" ) )
            {
                echo '<br>' . $_SERVER['SERVER_NAME'] . $url;
                http_redirect( $_SERVER['SERVER_NAME'] . $url );
            }
            else 
            {
                header( 'Location: ' . $url );
            }
        }
    }

    /**
     * Required view
     * @param string $view
     * @param array $data = default false
     */
    protected function view( string $view, array $data = [] ) {
        
        require ROOT . 'app/views/' . $view . '.php';
    }
}
