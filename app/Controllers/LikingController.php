<?php

namespace App\Controllers;

use App\Services\LikingService;

class LikingController
{
    private LikingService $service;

    public function __construct(LikingService $service)
    {
        $this->service = $service;
    }

    public function like(array $vars): void
    {
        $user = $this->service->getUser('id', $vars['id']);
        $this->service->saveLike($user, $_POST['like']);

        header('Location:/lookingFor/' . $user->getId());
    }

    public function dislike(array $vars): void
    {
        $user = $this->service->getUser('id', $vars['id']);
        $this->service->saveDislike($user, $_POST['dislike']);

        header('Location:/lookingFor/' . $user->getId());
    }

}