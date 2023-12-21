<?php

namespace App\Factory;

use \App\Entity\RequestEntity;
abstract class CryptoNetwork
{
    abstract public function getCryptoNetworkConnector(): CryptoNetworkConnector;

    public function validate(RequestEntity $requestEntity): void
    {
        /** @var CryptoConnector $network */
        $network = $this->getCryptoNetworkConnector();
        $network->logIn();
        $network->validateAddress($requestEntity, $this->baseUrl);
        $network->storeData($requestEntity);
        $network->logout();
    }
}
