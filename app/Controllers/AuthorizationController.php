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

            echo 'user ' . $_POST['username'] . ' logged in';

            $link = $_SERVER['HTTP_ORIGIN'] .
                '/user/' .
                $this->service->findUser('name', $_POST['username'])->getId();

            $this->service->loginUser($this->service->findUser('name', $_POST['username']));
            header('Location:' . $link);
        } else {
            echo 'WRONG USERNAME OF PASSWORD';
        }

    }


}