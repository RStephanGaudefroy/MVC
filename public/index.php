<?php

define( 'ROOT', str_replace( 'public/index.php', '', $_SERVER['SCRIPT_FILENAME'] ) );

// Autoload class
require_once (ROOT . 'app/core/Autoloader.php');
spl_autoload_register(array('Autoloader', 'autoload'));

$app = new app\core\App;
