<?php
// Initialize session
session_start();

// define DEBUG as true during developpements, turn this at false in product mode
define('DEBUG', true);

// Define CONST
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', str_replace('public/index.php', '', $_SERVER['SCRIPT_FILENAME']));

// load App.php    
require_once (ROOT . 'Core' . DS . 'App.php');
    
// Initialize Applicaion
$app = new Core\App;