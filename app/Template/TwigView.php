<?php

namespace App\Template;

use App\Models\User;
use App\Models\UserImages;
use Twig\Environment;

class TwigView
{
    private Environment $environment;

    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    public function getEn(): Environment
    {
        return $this->environment;
    }

    public function linkInfo(string $link): array
    {
        return ['link' => $link];
    }

    public function userPageInfo(User $user, UserImages $images): array
    {
        return [
            'name' => $user->getName(),
            'gender' => $user->getGender(),
            'lookingFor' => $user->getLookingFor(),
            'personality' => $user->getPersonality(),
            'id' => $user->getId(),
            'first' => $images->getFirstImage(),
            'second' => $images->getSecondImage(),
            'third' => $images->getThirdImage(),
            'image' => 'Images/none.jpg'
        ];
    }

    public function lookingForPage(User $user, UserImages $images): array
    {
        $images = [
            $images->getFirstImage(),
            $images->getSecondImage(),
            $images->getThirdImage()
        ];

        return [
            'name' => $user->getName(),
            'gender' => $user->getGender(),
            'lookingFor' => $user->getLookingFor(),
            'personality' => $user->getPersonality(),
            'id' => $user->getId(),
            'userImage' => $images[rand(0, count($images)-1)],
            'image' => 'Images/none.jpg'
        ];

    }


}
