<?php

namespace App\Controllers;

use App\Utils\AbstractController;

class SessionController extends AbstractController
{
    public function login ()
    {
        require_once(__DIR__ . '/../Views/login.view.php');
    }

}