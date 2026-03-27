<?php
require_once(__DIR__ . '/../vendor/autoload.php');
session_start();
use Config\Router;

$router = new Router;

$router->addRoute('/', 'HomeController', 'index');
$router->addRoute('/404', 'ErrorController', 'notFound');
$router->addRoute('/inscription', 'RegisterController', 'register');
$router->addRoute('/connexion', 'SessionController', 'login');


$router->handleRequest();