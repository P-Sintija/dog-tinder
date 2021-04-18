<?php

namespace App\Controllers;

use App\Services\AuthorizationService;

class AuthorizationController
{
    private AuthorizationService $service;

    public function __construct(AuthorizationService $service)
    {
        $this->service = $service;
    }

    public function authorization(): void
    {
        if ($this->service->userExists($_POST['username'], $_POST['password'])) {

            $_SESSION['authId'] = $this->service->findUser('name', $_POST['username'])->getId();

            $link = $_SERVER['HTTP_ORIGIN'] .
                '/user/' .
                $this->service->findUser('name', $_POST['username'])->getId();

            header('Location:' . $link);
        } else {
            echo 'WRONG USERNAME OR PASSWORD';
        }

    }


}