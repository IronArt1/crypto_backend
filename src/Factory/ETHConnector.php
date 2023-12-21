<?php

namespace App\Factory;

use App\Entity\RequestEntity;

class ETHConnector extends GeneralConnector implements CryptoNetworkConnector
{
    public function __construct(protected string $login, protected string $password, protected string $baseUrl)
    {
        parent::__construct();
    }

    public function logIn(): void
    {
        // login functionality is here
    }

    public function logout(): void
    {
        // logout functionality is here
    }

    public function validateAddress(RequestEntity $requestEntity): void
    {
        $this->client->post();
    }

    public function storeData(RequestEntity $requestEntity): void
    {
        // storing functionality is here
    }
}