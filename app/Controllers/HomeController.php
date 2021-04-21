<?php

namespace App\Controllers;

class HomeController
{
    public function homePage(): void
    {
        require_once __DIR__ . '/../../public/Views/home.html';
    }
}