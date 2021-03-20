<?php
declare(strict_types=1);


namespace App\Vendor\Typicode\Users;


use App\Vendor\Model\User;
use App\Vendor\Typicode\TypicodeFetcherAbstract;
use App\Vendor\UsersFetcherInterface;

class TypicodeUsersFetcher extends TypicodeFetcherAbstract implements UsersFetcherInterface
{


    /**
     * @inheritDoc
     */
    public function fetch(): array
    {
        $data = [];
        foreach ($this->makeHttpRequest('/users') as $item) {
            $data[] = new User(
                (int)$item['id'],
                $item['name'],
                $item['username'],
                $item['email'],
            );
        }

        return $data;
    }
}