<?php

namespace App\Controllers;

class ErrorController
{

    static function notFound()
    {
        http_response_code(404);
        require_once(__DIR__ . '/../Views/errors/404.view.php' );
        exit();
    }

}