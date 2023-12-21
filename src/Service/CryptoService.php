<?php

namespace App\Service;

use App\Entity\RequestEntity;
use App\Enum\CryptoType;
use App\Factory\BTCCryptoConnector;
use App\Factory\ETHCryptoConnector;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class CryptoService
{
    public function __construct(
       // too much passing around is... it's better just instantiate in a certain constructor
       // #[Autowire(service: 'http_client')] protected Client $client
        #[Autowire(param: 'app.base.url')]
        private string $baseUrl
    )
    {
    }

    public function callCrypto(RequestEntity $requestEntity)
    {
        try {
            // here getAsset() should an instance of CryptoType. Don't have time for that)
            $factory = match ($requestEntity->getAsset()) {
                CryptoType::BTC->value => new BTCCryptoConnector(
                    'some login',
                    'some password',
                    $this->baseUrl
                ),
                CryptoType::ETH->value => new ETHCryptoConnector('some login', 'some password', $this->baseUrl),
                default => throw new \Exception('There is no such type of Crypto currency')
            };
            $factory->validate($requestEntity);
        } catch (\Exception $exception) {
            // do something here about it ...

            error_log($exception->getMessage(), $exception->getCode());
        }
    }
}