<?php
require_once(__DIR__ . '/../vendor/autoload.php');

//sauvegarde des données de l'utilisateur qui permet de lancer la fonctionnalité session_Start partout dans mon projet
session_start();
use Config\Router;

$router = new Router;

//les routes des pages web ('/nom de l'uri (le chemin), 'nom du Controller', 'nom de la méthode')
$router->addRoute('/', 'HomeController', 'index');
$router->addRoute('/404', 'ErrorController', 'notFound');
$router->addRoute('/inscription', 'RegisterController', 'register');
$router->addRoute('/connexion', 'SessionController', 'login');
$router->addRoute('/deconnexion', 'SessionController', 'logout');
$router->addRoute('/ajoutArticle', 'ArticleController', 'addArticle');
$router->addRoute('/article', 'ArticleController', 'getAllArticles');

//permet d'exécuter la requête en définissant les routes indiquées
$router->handleRequest();