<?php

namespace App\Template;

use App\Models\User;
use App\Models\UserCollection;
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

    public function lookingForPage(User $user, User $interest, ?string $image): array
    {
        return [
            'userID' => $user->getId(),
            'name' => $interest->getName(),
            'gender' => $interest->getGender(),
            'lookingFor' => $interest->getLookingFor(),
            'personality' => $interest->getPersonality(),
            'interestID' => $interest->getId(),
            'userImage' => $image,
            'image' => 'storage/Images/private/none.jpg'//'Images/none.jpg'
        ];
    }

    public function historyPage(UserCollection $likes, UserCollection $dislikes): array
    {
        $likedList = [];
        foreach ($likes->getUsers() as $like) {
            $likedList[] =
                [
                    'name' => $like->getName(),
                    'personality' => $like->getPersonality(),
                    'gender' => $like->getGender()
                ];
        }

        $dislikedList = [];
        foreach ($dislikes->getUsers() as $dislike) {
            $dislikedList[] =
                [
                    'name' => $dislike->getName(),
                    'personality' => $dislike->getPersonality(),
                    'gender' => $dislike->getGender()
                ];
        }

       return [
            'like' => $likedList,
            'dislike' => $dislikedList
        ];

    }

}
