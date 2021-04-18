<?php

namespace App\Controllers;

use App\Services\HistoryService;
use App\Template\TwigView;

class HistoryController
{
    private HistoryService $service;
    private TwigView $twig;

    public function __construct(HistoryService $service, TwigView $twig)
    {
        $this->service = $service;
        $this->twig = $twig;
    }

    public function history(): void
    {
        $user = $this->service->getUser('id', $_GET['id']);

        $likes = $this->service->searchLikes($user);

        $dislikes = $this->service->searchDislikes($user);

        echo $this->twig->getEn()->render(
            'likeHistory.html', $this->twig->historyPage($likes, $dislikes, $user)
        );

    }

}