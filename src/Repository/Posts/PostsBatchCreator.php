<?php
declare(strict_types=1);


namespace App\Repository\Posts;


use App\Vendor\Model\Post;
use Doctrine\DBAL\Connection;

class PostsBatchCreator
{

    /** @var Post[] */
    private array $posts;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function addPost(Post $post)
    {
        $this->posts[] = $post;
        return $this;
    }

    public function save(): int
    {
        if (count($this->posts) === 0) {
            return 0;
        }

        $sqlParts = [];
        $params = [];
        foreach ($this->posts as $post) {
            $sqlParts[] = '(?, ?, ?, ?)';

            $params = array_merge(
                $params,
                array(
                    $post->getId(),
                    $post->getUserId(),
                    $post->getTitle(),
                    $post->getBody(),
                )
            );
        }

        $sql = sprintf(
            '
                insert into posts
                    (id, userId, title, body)
                values
                    %s
                on duplicate key update
                    userId = values(userId),
                    title = values(title),
                    body = values(body)
            ',
            implode(',', $sqlParts)
        );
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);

        return $stmt->rowCount();
    }

}