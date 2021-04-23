<?php

namespace App\ Controllers;

use App\Services\LookingForService;
use App\ViewContent\Content;
use Template;


class LookingForController
{
    private LookingForService $service;
    private Content $content;
    private Template $view;

    public function __construct(LookingForService $service, Content $content, Template $view)
    {
        $this->service = $service;
        $this->content = $content;
        $this->view = $view;
    }

    public function lookingFor(array $vars): string
    {
        $user = $this->service->getUser('id', $vars['id']);
        $interest = $this->service->getInterestUser($user);

        if ($interest != null) {
            $image = $this->service->getInterestsImages('id', $interest->getId())->getFirstImage();
            return $this->view->view(
                'lookingFor.html', $this->content->lookingForPage($user, $interest, $image));
        }
        return $this->view->view(
            'lookingFor.html', $this->content->nothingToLike(
            $user, 'Sorry! Nobody to smell!'));
    }

}