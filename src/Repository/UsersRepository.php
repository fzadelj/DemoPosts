<?php
declare(strict_types=1);


namespace App\Repository;


use App\Repository\Users\UsersBatchCreator;

class UsersRepository extends RepositoryAbstract
{

    public function getNewBatchCreator(): UsersBatchCreator
    {
        return new UsersBatchCreator($this->getConnection());
    }

}