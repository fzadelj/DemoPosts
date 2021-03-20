<?php
declare(strict_types=1);


namespace App\Controller\Api;


use App\Entity\Users;
use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends ApiControllerAbstract
{
    private UsersRepository $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function execute(Request $request): Response
    {
        return $this->getList(
            $this->usersRepository,
            $request->get('sort'),
            function (Users $post) {
                return $this->convertRecord($post);
            }
        );
    }

    protected function convertRecord(Users $user): array
    {
        return [
            'type' => 'posts',
            'id' => (string)$user->getId(),
            'attributes' => [
                'name' => $user->getName(),
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getAllowedSortKeys(): array
    {
        return [
            'id',
            'name',
            'username',
            'email',
        ];
    }
}