<?php

namespace App\Controllers;

use App\Requests\AuthorizationRequest;
use App\Services\AuthorizationService;
use App\ViewContent\Content;
use Template;

class AuthorizationController
{
    private AuthorizationService $service;
    private Content $content;
    private Template $view;

    public function __construct(
        AuthorizationService $service,
        Content $content,
        Template $view)
    {
        $this->service = $service;
        $this->content = $content;
        $this->view = $view;
    }

    public function authorization(): string
    {
        $request = new AuthorizationRequest($_POST['username'], $_POST['password']);
        if ($this->service->userExists($request)) {

            $user = $this->service->findUser('name', $request->getUsername());
            $_SESSION['authId'] = $user->getId();

            $link = $_SERVER['HTTP_ORIGIN'] . '/user/' . $user->getId();
            header('Location:' . $link);

        }
        return $this->view->view('home.html', $this->content->homePage(
            'wrong user name or password'));
    }

}