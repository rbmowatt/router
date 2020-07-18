<?php

require('./../vendor/autoload.php');
require_once('./controllers.php');

use RbMowatt\Router\Router;

Router::resource('patients');
Router::resource('patients.metrics');
$router = new Router;
try{
    echo $router->dispatch($_SERVER['REQUEST_URI']);
}
catch(Exception $e)
{
    echo $e->getMessage();
}
