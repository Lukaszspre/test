<?php
declare(strict_types=1);
namespace App\Task;

class BlogPostDTO implements \JsonSerializable
{
    public int $postId;
    public int $userId;
    #[Assert\Length(max: 20)]
    public string $title;
    public string $content;

    public static function updateFromEntity(BlogPost $blogPost): BlogPostDTO
    {
        $self = new self();
        $self->postId = $blogPost->getPostId();
        $self->userId = $blogPost->getUserId();
        $self->title = $blogPost->getTitle();
        $self->content = $blogPost->getContent();

        return $self;
    }

    public function jsonSerialize(): array
    {
        return [
            'postId' => $this->postId,
            'userId' => $this->userId,
            'title' => $this->title,
            'content' => $this->content,
        ];
    }
}