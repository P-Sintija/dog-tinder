<?php

namespace App\ Controllers;

use App\Services\LookService;
use App\Template\TwigView;


class LookController
{
    private LookService $service;
    private TwigView $twigView;

    public function __construct(LookService $service, TwigView $twigView)
    {
        $this->service = $service;
        $this->twigView = $twigView;
    }

    public function lookingFor(array $vars): void
    {
        var_dump($vars);
        var_dump($_GET);
       // $user = $this->service->getUser('id', $_GET['id']);
        $user = $this->service->getUser('id', $vars['id']);
        $interest = $this->service->getInterestUser($user);

        $image = $this->service->getInterestsImage('id', $interest->getId());

        echo $this->twigView->getEn()->render(
            'lookingFor.html', $this->twigView->lookingForPage($user, $interest, $image));

    }

}