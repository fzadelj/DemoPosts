<?php
declare(strict_types=1);


namespace App\Repository;


use App\Repository\Posts\PostsBatchCreator;

class PostsRepository extends RepositoryAbstract
{

    public function getNewBatchCreator(): PostsBatchCreator
    {
        return new PostsBatchCreator($this->getConnection());
    }

}