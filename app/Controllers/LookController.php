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

        $user = $this->service->getUser('id', $vars['id']);
        $interest = $this->service->getInterestUser($user);

        if($interest != null) {
            $image = $this->service->getInterestsImages('id', $interest->getId())->getFirstImage();

            echo $this->twigView->getEn()->render(
                'lookingFor.html', $this->twigView->lookingForPage($user, $interest, $image,1));
        } else {
            echo 'nothing to like ';
        }

    }

}