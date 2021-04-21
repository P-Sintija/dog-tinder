<?php

namespace App\Validations;

use App\Repositories\UserRepository;
use App\Requests\SubmissionRequest;

class SubmissionValidation
{
    private UserRepository $userRepository;
    private SubmissionError $error;

    public function __construct(UserRepository $userRepository, SubmissionError $error)
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

    public function getPersonalityError(): string
    {
        return $this->error->getPersonalityError();
    }

    public function validateSubmission(SubmissionRequest $request): bool
    {
        return $this->validatename($request->getName()) &&
            $this->validatePassword($request->getPassword(), $request->getName()) &&
            $this->validatePersonality($request->getPersonality());
    }

    private function validateName(string $name): bool
    {

        if ($this->userRepository->has($name)) {
            $this->error->setNameError('name already exists');
        }
        return !$this->userRepository->has($name) && strlen($name) > 2;
    }

    private function validatePassword(string $password, string $name): bool
    {
        if ($password !== strtolower($name)) {
            $this->error->setPasswordError('invalid password');
        }
        return $password === strtolower($name);
    }

    private function validatePersonality(string $personality): bool
    {
        if (strlen($personality) > 255) {
            $this->error->setPersonalityError('input too long');
        }
        return strlen($personality) <= 255;
    }

}