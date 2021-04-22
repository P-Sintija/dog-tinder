<?php

namespace App\Controllers;

use App\Services\HistoryService;

use App\ViewContent\Content;
use Template;

class HistoryController
{
    private HistoryService $service;
    private Content $content;
    private Template $view;

    public function __construct(HistoryService $service, Content $content, Template $view)
    {
        $this->service = $service;
        $this->content = $content;
        $this->view = $view;
    }

    public function history(): void
    {
        $user = $this->service->getUser('id', $_GET['id']);
        $likes = $this->service->searchLikes($user);
        $dislikes = $this->service->searchDislikes($user);

        echo $this->view->view(
            'likeHistory.html', $this->content->historyPage($likes, $dislikes, $user)
        );
    }

}