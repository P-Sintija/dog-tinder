<?php

namespace App\ViewContent;

use App\Models\User;
use App\Models\UserCollection;
use App\Models\UserImages;
use App\Repositories\UserImageRepository;


class Content
{
    private UserImageRepository $imageRepository;

    public function __construct(UserImageRepository $imageRepository)
    {

        $this->imageRepository = $imageRepository;
    }

    public function nothingToLike(User $user, string $message): array
    {
        return [
            'message' => $message,
            'userID' => $user->getId(),
        ];
    }

    public function homePage(string $authorization): array
    {
        return ['status' => $authorization];
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
            'firstImage' => $this->imageRepository->searchUserImages('id', $interest->getId())->getFirstImage(),
            'lastImage' => $this->imageRepository->searchUserImages('id', $interest->getId())->getThirdImage()
        ];
    }

    public function submitErrors($name, $password, $personality): array
    {
        return [
            'nameError' => $name,
            'passwordError' => $password,
            'personalityError' => $personality
        ];
    }


    public function historyPage(UserCollection $likes, UserCollection $dislikes, User $user): array
    {
        return [
            'userID' => $user->getId(),
            'like' => $this->userList($likes),
            'dislike' => $this->userList($dislikes)
        ];
    }

    private function userList(UserCollection $users): array
    {
        $userList = [];
        foreach ($users->getUsers() as $user) {
            $userList[] =
                [
                    'id' => $user->getId(),
                    'name' => $user->getName(),
                    'personality' => $user->getPersonality(),
                    'gender' => $user->getGender(),
                    'userImage' => $this->imageRepository->searchUserImages('id', $user->getId())->getFirstImage(),
                ];
        }
        return $userList;
    }


}
