<?php
namespace App\Models;

class UserLikingCollection
{
    private array $likingList=[];

    public function add(UserLiking $user): void
    {
        $this->likingList[] = $user;
    }

    public function getUsers(): array
    {
        return $this->likingList;
    }
}