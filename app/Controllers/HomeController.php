<?php

namespace App\Controllers;

use App\ViewContent\Content;
use Template;

class HomeController
{
    private Content $content;
    private Template $view;

    public function __construct(Content $content, Template $view)
    {
        $this->content = $content;
        $this->view = $view;
    }

    public function homePage(): string
    {
        return $this->view->view('home.html', $this->content->homePage(''));
    }
}