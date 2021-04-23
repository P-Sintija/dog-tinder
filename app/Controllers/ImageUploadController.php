<?php

namespace App\Controllers;

use App\Requests\ImageRequest;
use App\Services\ImageUploadService;
use App\Services\UserService;
use App\Validations\ImageValidation;
use App\ViewContent\Content;
use Template;


class ImageUploadController
{
    private ImageUploadService $service;
    private ImageValidation $validation;
    private UserService $userService;
    private Content $content;
    private Template $view;

    public function __construct(
        ImageUploadService $service,
        ImageValidation $validation,
        UserService $userService,
        Content $content,
        Template $view
    )
    {
        $this->service = $service;
        $this->validation = $validation;
        $this->userService = $userService;
        $this->content = $content;
        $this->view = $view;
    }


    public function upload(array $vars): string
    {
        $fileExtension = explode('.', $_FILES['image']['name']);
        $fileExtensionLowercase = strtolower(end($fileExtension));

        $image = new ImageRequest(
            $_FILES['image']['name'],
            $_FILES['image']['type'],
            $_FILES['image']['tmp_name'],
            $_FILES['image']['error'],
            $_FILES['image']['size'],
            $fileExtensionLowercase,
            (int)$vars['id'],
            $_POST['upload']
        );

        if ($this->validation->checkFileProperties($image)) {
            $this->service->uploadImage($image);
        }

        $user = $this->userService->findUser('id', $vars['id']);
        $images = $this->userService->findImages('id', $vars['id']);

        return $this->view->view('userPage.html',
            $this->content->userPageInfo($user, $images, $this->validation));
    }

}