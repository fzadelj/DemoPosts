<?php
declare(strict_types=1);


namespace App\Repository;


use App\Entity\Users;
use App\Repository\Users\UsersBatchCreator;
use Doctrine\Persistence\ManagerRegistry;

class UsersRepository extends RepositoryAbstract
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
    }

    public function getNewBatchCreator(): UsersBatchCreator
    {
        return new UsersBatchCreator($this->getEntityManager()->getConnection());
    }

}