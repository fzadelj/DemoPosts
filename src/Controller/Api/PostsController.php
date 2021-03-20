<?php
declare(strict_types=1);


namespace App\Controller\Api;


use App\Entity\Posts;
use App\Repository\PostsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostsController extends ApiControllerAbstract
{
    private PostsRepository $postsRepository;

    public function __construct(PostsRepository $postsRepository)
    {
        $this->postsRepository = $postsRepository;
    }

    public function execute(Request $request): Response
    {
        return $this->getList(
            $this->postsRepository,
            $request->get('sort'),
            function (Posts $post) {
                return $this->convertRecord($post);
            }
        );
    }

    public function getForUser(int $userId, Request $request): Response
    {
        return $this->getList(
            $this->postsRepository,
            $request->get('sort'),
            function (Posts $post) {
                return $this->convertRecord($post);
            },
            [
                'userId' => $userId
            ]
        );
    }


    protected function convertRecord(Posts $post): array
    {
        return [
            'type' => 'posts',
            'id' => (string)$post->getId(),
            'attributes' => [
                'title' => $post->getTitle(),
                'body' => $post->getBody(),
                'userId' => (string)$post->getUser()->getId(),
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getAllowedSortKeys(): array
    {
        return [
            'id',
            'title',
            'userId',
        ];
    }
}