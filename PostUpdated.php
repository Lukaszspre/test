<?php
declare(strict_types=1);
namespace App\Task;

final class PostUpdated implements Event
{
    public function __construct(
        private int $postId,
        private int $userId
    ) {}

    public function getPostId(): int
    {
        return $this->postId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}