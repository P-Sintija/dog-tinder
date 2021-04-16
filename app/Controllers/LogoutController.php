<?php

namespace App\Controllers;

use App\Services\LogoutUserService;

class LogoutController
{
    private LogoutUserService $service;

    public function __construct(LogoutUserService $service)
    {
        $this->service = $service;
    }


    public function logout(): void
    {
        $this->service->logoutUser($_POST['id']);
        header('Location:/');
    }
}