<?php


namespace App\Vendor;


use App\Vendor\Model\Post;

interface PostsFetcherInterface
{

    /**
     * @return Post[]
     */
    public function fetch(): array;

}