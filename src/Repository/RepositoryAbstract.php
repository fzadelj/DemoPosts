<?php
declare(strict_types=1);


namespace App\Repository;


use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;

class RepositoryAbstract
{
    private Connection $connection;

    public function __construct(ManagerRegistry $connection)
    {
        $this->connection = $connection->getConnection();
    }

    protected function getConnection(): Connection
    {
        return $this->connection;
    }

}