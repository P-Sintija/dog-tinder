<?php

namespace App\Controllers;

use App\Requests\AuthorizationRequest;
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
        $request = new AuthorizationRequest($_POST['username'], $_POST['password']);
        if ($this->service->userExists($request)) {

            $user = $this->service->findUser('name', $request->getUsername());
            $_SESSION['authId'] = $user->getId();

            $link = $_SERVER['HTTP_ORIGIN'] . '/user/' . $user->getId();
            header('Location:' . $link);

        } else {

            echo 'WRONG USERNAME OR PASSWORD';
        }
    }


}