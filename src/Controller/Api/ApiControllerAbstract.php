<?php
declare(strict_types=1);


namespace App\Controller\Api;


use App\Repository\RepositoryAbstract;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

abstract class ApiControllerAbstract extends AbstractController
{

    protected function getList(RepositoryAbstract $repository, ?string $sort, callable $callbackForEachRow, array $conditions = [])
    {
        try {
            $orderBy = [];
            if ($sort) {
                foreach (explode(',', $sort) as $sortKey) {
                    $direction = 'ASC';
                    if (strpos($sortKey, '-') === 0) {
                        $direction = 'DESC';
                        $sortKey = substr($sortKey, 1);
                    }

                    if (!in_array($sortKey, $this->getAllowedSortKeys())) {
                        throw new \InvalidArgumentException(
                            sprintf(
                                'Sort not allowed by key: "%s".',
                                $sortKey
                            )
                        );
                    }

                    $orderBy[$sortKey] = $direction;
                }
            }

            $data = $repository->findBy(
                $conditions,
                $orderBy
            );

            $response = [];
            foreach ($data as $row) {
                $response[] = $callbackForEachRow($row);
            }

            return $this->toResponse([
                'data' => $response
            ]);
        } catch (Throwable $e) {
            return $this->toResponse(
                [
                    'errors' => [
                        'status' => $e->getCode(),
                        'detail' => $e->getMessage(),
                    ]
                ],
                500
            );
        }
    }

    /**
     * @return string[]
     */
    abstract protected function getAllowedSortKeys(): array;

    protected function toResponse(array $data, ?int $httpCode = null): Response
    {
        return new Response(
            json_encode($data, JSON_PRETTY_PRINT),
            $httpCode ?: 200
        );
    }

}