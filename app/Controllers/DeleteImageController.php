<?php

namespace App\Controllers;

use App\Services\DeleteImageService;

class DeleteImageController
{
    private DeleteImageService $service;

    public function __construct(DeleteImageService $service)
    {
        $this->service = $service;
    }

    public function delete(array $vars): void
    {
        $this->service->delete($vars['id'], $_POST['delete']);

        $link = '/user/' . $vars['id'];
        header('Location:' . $link);
    }
}