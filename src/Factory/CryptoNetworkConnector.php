<?php

namespace App\Factory;

use App\Entity\RequestEntity;

interface CryptoNetworkConnector
{
    public function logIn(): void;

    public function logOut(): void;
    public function storeData(RequestEntity $requestEntity): void;

    public function validateAddress(RequestEntity $requestEntity): void;
}
