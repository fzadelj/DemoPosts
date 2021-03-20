<?php
declare(strict_types=1);


namespace App\Repository\Users;


use App\Vendor\Model\User;
use Doctrine\DBAL\Connection;

class UsersBatchCreator
{
    private array $users = [];
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function addUser(User $user): self
    {
        $this->users[] = $user;
        return $this;
    }

    public function save(): int
    {
        if (count($this->users) === 0) {
            return 0;
        }

        $sqlParts = [];
        $params = [];
        foreach ($this->users as $user) {
            $sqlParts[] = '(?, ?, ?, ?)';

            $params = array_merge(
                $params,
                array(
                    $user->getId(),
                    $user->getName(),
                    $user->getUsername(),
                    $user->getEmail()
                )
            );
        }

        $sql = sprintf(
            '
                insert into users
                    (id, name, username, email)
                values
                    %s
                on duplicate key update
                    name = values(name),
                    username = values(username),
                    email = values(email)
            ',
            implode(',', $sqlParts)
        );
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);

        return $stmt->rowCount();
    }

}