<?php

namespace App\Validations;

use App\Repositories\UserRepository;

class SubmitValidation
{
    private UserRepository $userRepository;
    private SubmitError $error;

    public function __construct(UserRepository $userRepository, SubmitError $error)
    {
        $this->userRepository = $userRepository;
        $this->error = $error;
    }

    public function getNameError(): string
    {
        return $this->error->getNameError();
    }

    public function getPasswordError(): string
    {
        return $this->error->getPasswordError();
    }

    public function validateSubmission(string $name, string $password): bool
    {
        return $this->validatename($name) && $this->validatePassword($password, $name);
    }

    private function validateName(string $name): bool
    {

       if ($this->userRepository->has($name)){
           $this->error->setNameError('name already exists');
       }
       return !$this->userRepository->has($name) && strlen($name) > 2;
    }

    private function validatePassword(string $password, string $name): bool
    {
        if($password !== strtolower($name)){
            $this->error->setPasswordError('invalid password');
        }
        return $password === strtolower($name);
    }


}