<?php
declare(strict_types=1);

namespace App\Vendor;


use App\Vendor\Model\User;

interface UsersFetcherInterface
{

    /**
     * @return User[]
     */
    public function fetch(): array;

}