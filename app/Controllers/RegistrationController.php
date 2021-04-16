<?php

namespace App\Controllers;

use App\Services\RegisterUserService;
use App\Models\User;
use App\Template\TwigView;


class RegistrationController
{
    private RegisterUserService $service;
    private TwigView $twig;

    public function __construct(RegisterUserService $service, TwigView $twig)
    {
        $this->service = $service;
        $this->twig = $twig;
    }

    public function registrationPage(): void
    {
        require_once __DIR__ . '/../../public/Views/submit.html';
    }


    public function submitUser(): void
    {
        //todo validē pēc unikāla vārda un vai visi lauki aizpildīti;

        $_SESSION['new_user'] = [
            'name' => $_POST['name'],
            'password' =>  password_hash($_POST['password'], PASSWORD_BCRYPT),
            'personality' => $_POST['personality'],
            'gender' => $_POST['gender'],
            'lookingFor' => $_POST['lookingFor']
        ];

        $link = $this->service->getRegistrationLink(new User(
            $_SESSION['new_user']['name'],
            $_SESSION['new_user']['password'],
            $_SESSION['new_user']['personality'],
            $_SESSION['new_user']['gender'],
            $_SESSION['new_user']['lookingFor'],
        ));

        echo $this->twig->getEn()->render('registration.html', $this->twig->linkInfo($link));

    }


    public function registerUser(): void
    {
        //todo is token vienāds ar user pasword;

        $this->service->saveNewUser(new User(
            $_SESSION['new_user']['name'],
            $_SESSION['new_user']['password'],
            $_SESSION['new_user']['personality'],
            $_SESSION['new_user']['gender'],
            $_SESSION['new_user']['lookingFor'],
        ));
        unset($_SESSION['new_user']);
        header('Location:/');
    }



}