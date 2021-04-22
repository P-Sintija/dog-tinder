<?php

namespace App\Controllers;

use App\Requests\SubmissionRequest;
use App\Services\RegisterUserService;
use App\Models\User;
use App\Validations\SubmissionValidation;
use App\ViewContent\Content;
use Template;

class RegistrationController
{
    private RegisterUserService $service;
    private SubmissionValidation $validation;
    private Content $content;
    private Template $view;

    public function __construct(
        RegisterUserService $service,
        SubmissionValidation $validation,
        Content $content,
        Template $view
    )
    {
        $this->service = $service;
        $this->validation = $validation;
        $this->content = $content;
        $this->view = $view;
    }

    public function registrationPage(): string
    {
        return $this->view->view('submit.html', $this->content->submitErrors(
            $this->validation->getNameError(),
            $this->validation->getPasswordError(),
            $this->validation->getPersonalityError()
        ));
    }


    public function submitUser(): string
    {
        if ($this->validation->validateSubmission(new SubmissionRequest(
            $_POST['name'],
            $_POST['password'],
            $_POST['personality']
        ))) {

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

            return $this->view->view('registration.html', $this->content->linkInfo($link));

        } else {

            return $this->view->view(
                'submit.html',
                $this->content->submitErrors(
                    $this->validation->getNameError(),
                    $this->validation->getPasswordError(),
                    $this->validation->getPersonalityError()
                ));
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