<?php
declare(strict_types=1);


namespace App\Repository;


use App\Entity\Posts;
use App\Repository\Posts\PostsBatchCreator;
use Doctrine\Persistence\ManagerRegistry;

class PostsRepository extends RepositoryAbstract
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Posts::class);
    }

    public function getNewBatchCreator(): PostsBatchCreator
    {
        return new PostsBatchCreator($this->getEntityManager()->getConnection());
    }

}