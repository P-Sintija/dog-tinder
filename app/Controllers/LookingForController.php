<?php

namespace App\ Controllers;

use App\Services\LookingForService;
use App\Template\TwigView;


class LookingForController
{
    private LookingForService $service;
    private TwigView $twigView;

    public function __construct(LookingForService $service, TwigView $twigView)
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