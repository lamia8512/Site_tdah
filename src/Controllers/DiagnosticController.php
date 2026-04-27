<?php

namespace App\Controllers;

class DiagnosticController
{
    public function diagnostic()
    {
        require_once(__DIR__ . '/../Views/diagnostic.view.php');
    }

}