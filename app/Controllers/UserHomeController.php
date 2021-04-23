<?php

namespace App\Controllers;

use App\Services\UserService;
use App\Validations\ImageValidation;
use App\ViewContent\Content;
use Template;


class UserHomeController
{
    private UserService $service;
    private Content $content;
    private Template $view;
    private ImageValidation $errors;

    public function __construct(
        UserService $service,
        Content $content,
        Template $view,
        ImageValidation $errors
    )
    {
        $this->service = $service;
        $this->content = $content;
        $this->view = $view;
        $this->errors = $errors;
    }

    public function userPage(array $vars): string
    {
        $user = $this->service->findUser('id', $vars['id']);
        $images = $this->service->findImages('id', $vars['id']);
        return $this->view->view('userPage.html',
            $this->content->userPageInfo($user, $images, $this->errors));
    }
}