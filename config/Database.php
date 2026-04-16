<?php

// Déclare le namespace de ce fichier : en PHP, c’est un espace de noms qui sert à organiser le code et éviter les conflits
namespace Config;

// Importe la classe PDO (PDO permet de se connecter à une base de données, exécuter des requêtes SQL, sécuriser les requêtes (anti injection SQL))
use PDO;
// Importe la classe Exception pour pouvoir l'utiliser dans ce fichier (une erreur que PHP peut gérer proprement)
use Exception;

class Database
{
    // C’est une méthode statique qui permet généralement de récupérer une connexion à la base de données
    static function getConnection()
    {
        try {
            // Connexion à la base
            $pdo = new PDO(
                "mysql:host=database;dbname=tdahdbd;charset=utf8",
                "root",
                "admin"
            );
            //echo "Connexion réussie ✅";


        } catch (Exception $e) {
            // Gestion d'erreur
            die("Erreur de connexion ❌ : " . $e->getMessage());
        };
        return $pdo;
    }
}