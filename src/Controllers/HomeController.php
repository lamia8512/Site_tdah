<?php

namespace App\Controllers;

// Déclare une classe appelée HomeController
class HomeController
{
    // Méthode publique appelée index (souvent la méthode principale d’un contrôleur) qui affiche la page principale d’un contrôleur
    public function index()
    {
        require_once(__DIR__ . '/../Views/home.view.php');
    }

}

/* 
* Un HomeController est un contrôleur qui sert à gérer la page d’accueil d'un site (contrôleur de la page principale (homepage))
* Exemple :
* Le site = une maison
* HomeController = l’entrée principale
* index est généralement la méthode ou page par défaut dans un système web (souvent en MVC) donc le point d’entrée principal
*/