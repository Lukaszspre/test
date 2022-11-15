<?php
declare(strict_types=1);
namespace App\Task;

use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;

class BlogPostDTO implements \JsonSerializable
{
    #[ORM\Column(type: Types::INTEGER)]
    public int $postId;

    #[ORM\Column(type: Types::INTEGER)]
    public int $userId;

    #[ORM\Column(type: Types::STRING)]
    #[Assert\Length(max: 20)]
    #[Assert\NotBlank(message: 'post.blank')]
    public string $title;
    
    #[ORM\Column(type: Types::TEXT)]
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