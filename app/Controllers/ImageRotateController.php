<?php

namespace App\Controllers;

use App\Services\ImageRotateService;
use App\ViewContent\Content;
use Template;


class ImageRotateController
{
    private ImageRotateService $service;
    private Content $content;
    private Template $view;

    public function __construct(ImageRotateService $service, Content $content, Template $view)
    {
        $this->service = $service;
        $this->content = $content;
        $this->view = $view;
    }

    public function next(array $vars): string
    {
        $user = $this->service->getUser('id', $vars['id']);
        $interest = $this->service->getUser('id', key($_POST));
        $nextImage = $this->service->nextImage($interest, $_POST[key($_POST)]);

        return $this->view->view('lookingFor.html',
            $this->content->lookingForPage($user, $interest, $nextImage));
    }

    public function previous(array $vars): string
    {
        $user = $this->service->getUser('id', $vars['id']);
        $interest = $this->service->getUser('id', key($_POST));
        $previousImage = $this->service->previousImage($interest, $_POST[key($_POST)]);

        return $this->view->view('lookingFor.html',
            $this->content->lookingForPage($user, $interest, $previousImage));
    }
}