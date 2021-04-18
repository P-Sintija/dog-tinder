<?php

namespace App\Controllers;

use App\Services\ImageRotateService;
use App\Template\TwigView;

class ImageRotateController
{
    private ImageRotateService $service;
    private TwigView $twigView;

    public function __construct(ImageRotateService $service, TwigView $twigView)
    {
        $this->service = $service;
        $this->twigView = $twigView;
    }

    public function next(array $vars): void
    {
        $user = $this->service->getUser('id', $vars['id']);
        $interest = $this->service->getUser('id', key($_POST));

        if ($_POST[key($_POST)] == 1) {

            $image = $this->service->getInterestsImages('id', $interest->getId())->getSecondImage();
            echo $this->twigView->getEn()->render(
                'lookingFor.html', $this->twigView->lookingForPage($user, $interest, $image, 2));

        } else if ($_POST[key($_POST)] == 2) {

            $image = $this->service->getInterestsImages('id', $interest->getId())->getThirdImage();
            echo $this->twigView->getEn()->render(
                'lookingFor.html', $this->twigView->lookingForPage($user, $interest, $image, 3));

        }
    }

    public function previous(array $vars): void
    {
        $user = $this->service->getUser('id', $vars['id']);
        $interest = $this->service->getUser('id', key($_POST));

        if ($_POST[key($_POST)] == 3) {

            $image = $this->service->getInterestsImages('id', $interest->getId())->getSecondImage();
            echo $this->twigView->getEn()->render(
                'lookingFor.html', $this->twigView->lookingForPage($user, $interest, $image, 2));

        } else if ($_POST[key($_POST)] == 2) {

            $image = $this->service->getInterestsImages('id', $interest->getId())->getFirstImage();
            echo $this->twigView->getEn()->render(
                'lookingFor.html', $this->twigView->lookingForPage($user, $interest, $image, 1));

        }
    }
}