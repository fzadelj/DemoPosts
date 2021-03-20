<?php
declare(strict_types=1);


namespace App\Vendor\Typicode;


use App\Vendor\Exception\VendorServiceUnavailableException;
use GuzzleHttp\Client;
use RuntimeException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Throwable;

abstract class TypicodeFetcherAbstract
{
    private ContainerInterface $container;
    private Client $client;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->client = new Client();
    }

    protected function makeHttpRequest(string $path): array
    {
        $url = sprintf(
            '%s%s',
            $this->container->getParameter('vendor_typicode_api_url'),
            $path
        );

        try {
            $response = $this->client->request('GET', $url);

            if ($response->getStatusCode() !== 200) {
                throw new RuntimeException('Invalid response code');
            }

            return json_decode($response->getBody()->getContents(), true);
        } catch (Throwable $e) {
            throw new VendorServiceUnavailableException(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

}