<?php

namespace App\Controllers;



class LogoutController
{

    public function logout(): void
    {
        unset($_SESSION['authId']);
        header('Location:/');
    }
}