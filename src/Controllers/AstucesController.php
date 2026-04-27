<?php

namespace App\Controllers;

class AstucesController
{
    public function astuces()
    {
        require_once(__DIR__ . '/../Views/astuces.view.php');
    }

}