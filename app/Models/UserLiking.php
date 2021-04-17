<?php

namespace App\Models;

class UserLiking
{
    private int $id;
    private ?string $like;
    private ?string $dislike;

    public function __construct(int $id, string $like = null, string $dislike = null)
    {
        $this->id = $id;
        $this->like = $like;
        $this->dislike = $dislike;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLike(): ?string
    {
        return $this->like;
    }

    public function getDislike(): ?string
    {
        return $this->dislike;
    }
}
