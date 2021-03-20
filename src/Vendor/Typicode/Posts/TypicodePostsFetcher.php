<?php
declare(strict_types=1);


namespace App\Vendor\Typicode\Posts;


use App\Vendor\Model\Post;
use App\Vendor\PostsFetcherInterface;
use App\Vendor\Typicode\TypicodeFetcherAbstract;

class TypicodePostsFetcher extends TypicodeFetcherAbstract implements PostsFetcherInterface
{

    /**
     * @inheritDoc
     */
    public function fetch(): array
    {
        $data = [];
        foreach ($this->makeHttpRequest('/posts') as $item) {
            $data[] = new Post(
                (int)$item['id'],
                (int)$item['userId'],
                $item['title'],
                $item['body'],
            );
        }

        return $data;
    }
}