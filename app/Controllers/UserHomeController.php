<?php

namespace App\Controllers;


use App\Services\UserService;
use App\Template\TwigView;


class UserHomeController
{
    private UserService $service;
    private TwigView $twig;

    public function __construct(UserService $service, TwigView $twig)
    {
        $this->service = $service;
        $this->twig = $twig;
    }

    public function userPage(array $vars): void
    {
        //todo if exixts
        //todo chech if logged in

        if ($this->service->findUser('id', (int)$vars['id'])->isLoggedIn()) {

            $user = $this->service->findUser('id', $vars['id']);
            $images = $this->service->findImages('id', $vars['id']);

            echo $this->twig->getEn()->render(
                'userPage.html', $this->twig->userPageInfo($user, $images));


        } else {
            var_dump('not logged in');
        }

    }


}