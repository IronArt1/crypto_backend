<?php

namespace App\Factory;

class ETHCryptoConnector extends CryptoNetwork
{
    public function __construct(protected string $login, protected string $password, protected string $baseUrl)
    {}

    public function getCryptoNetworkConnector(): CryptoNetworkConnector
    {
        return new ETHConnector($this->login, $this->password, $this->baseUrl);
    }

}
