<?php

namespace App\Factory;

class BTCCryptoConnector extends CryptoNetwork
{
    public function __construct(protected string $login, protected string $password, protected string $baseUrl)
    {}

    public function getCryptoNetworkConnector(): CryptoNetworkConnector
    {
        return new BTCConnector($this->login, $this->password, $this->baseUrl);
    }

}
