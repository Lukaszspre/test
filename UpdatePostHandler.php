<?php
declare(strict_types=1);
namespace App\Task;

use App\EventDispatcher;
use App\FailedToUpdatePost;
use App\PostDoesNotExist;
use App\PostUpdater;
use App\TitleTooLong;
use App\Task\UpdatePost;

final class UpdatePostHandler implements PostUpdater, EventDispatcher
{
    public function __construct(
        private EventDispatcher $eventDispatcher,
        private PostUpdater $postUpdater,
        private LoggerInterface $logger
    ) {}

    /**
     * @throws FailedToUpdatePost
     * @throws PostDoesNotExist
     * @throws TitleTooLong
     **/
    public function handle(UpdatePost $command): void
    {
        try {
            $updatePost = new BlogPost();
            $updatePost->setPostId($command->getPostId());
            $updatePost->setUserId($command->getUserId());
            $updatePost->setTitle($command->getTitle());
            $updatePost->setContent($command->getContent());

            $this->postUpdater->saveEnity($updatePost);

        } catch (
        PostDoesNotExist|
        TitleTooLong
        $exception) {

            $this->logger->error(sprintf(
                'Couldn\'t update post: %s',
                $exception->getMessage()
            ));

        } catch (PostBlockedForEditing $exception) {
            throw new \FailedToUpdatePost($exception->getMessage());

        } catch (\Throwable $exception) {
            throw new \FailedToUpdatePost($exception->getMessage());
        }
    }

    public function update(BlogPostDTO $blogPostDTO): UpdatePost
    {
        return UpdatePost::updateFromDTO($blogPostDTO);
    }

    public function dispatch(Event $event): BlogPostDTO|null
    {
        $blogPost = $this->findEntity(BlogPost::class, [
            'postId' => $event->getPostId(),
            'userId' => $event->getUserId()
        ]);

        return $blogPost ? BlogPostDTO::updateFromEntity($blogPost) : null;
    }
}