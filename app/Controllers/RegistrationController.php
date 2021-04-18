<?php

namespace App\Controllers;

use App\Services\RegisterUserService;
use App\Models\User;
use App\Template\TwigView;
use App\Validations\SubmitValidation;


class RegistrationController
{
    private RegisterUserService $service;
    private TwigView $twig;
    private SubmitValidation $validation;

    public function __construct(
        RegisterUserService $service,
        TwigView $twig,
        SubmitValidation $validation)
    {
        $this->service = $service;
        $this->twig = $twig;
        $this->validation = $validation;
    }

    public function registrationPage(): void
    {
        echo $this->twig->getEn()->render(
            'submit.html',
            $this->twig->submitErrors(
                $this->validation->getNameError(),
                $this->validation->getPasswordError()));
    }


    public function submitUser(): void
    {

        if ($this->validation->validateSubmission($_POST['name'], $_POST['password'])) {
            $_SESSION['new_user'] = [
                'name' => $_POST['name'],
                'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
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
        } else {

            echo $this->twig->getEn()->render(
                'submit.html',
                $this->twig->submitErrors(
                    $this->validation->getNameError(),
                    $this->validation->getPasswordError()));
        }


    }

    public function registerUser(): void
    {
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