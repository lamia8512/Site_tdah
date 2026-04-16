<?php

namespace App\Controllers;

// Déclare une classe appelée ErrorController
class ErrorController
{
    // Méthode statique appelée notFound, utilisée pour gérer une erreur 404 (page non trouvée)
    static function notFound()
    {
        http_response_code(404);
        require_once(__DIR__ . '/../Views/errors/404.view.php' );
        exit();
    }

}