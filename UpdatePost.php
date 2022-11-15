<?php
declare(strict_types=1);
namespace App\Task;

use Webmozart\Assert\Assert;

final class UpdatePost
{
    public function __construct(
        private int $postId,
        private int $userId,
        private string $title,
        private string $content
    ) {}

    public static function updateFromDTO(BlogPostDTO $blogPostDTO): self
    {
        Assert::isInstanceOf($blogPostDTO, BlogPostDTO::class);

        return new self(
            $blogPostDTO->postId,
            $blogPostDTO->userId,
            $blogPostDTO->title,
            $blogPostDTO->content

        );
    }

    public function getPostId(): int
    {
        return $this->postId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}