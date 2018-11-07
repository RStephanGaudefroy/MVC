<?php

namespace app\controllers;

class HomeController extends \app\core\Controller
{
  public function index() 
  {
    if ( ( $this->session->read('auth') != null ) )
      {
          $this->view( 'home' );
      }
      else 
      {
          $this->view( 'auth/login' );
      }
  }
}
