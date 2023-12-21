<?php

namespace App\Factory;

use App\Entity\RequestEntity;
use App\Exception\EndpointClientException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;

class BTCConnector extends GeneralConnector implements CryptoNetworkConnector
{
    public function __construct(
        protected string $login,
        protected string $password,
        protected string $baseUrl
    )
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

    /**
     * @throws GuzzleException
     * @throws EndpointClientException
     */
    public function validateAddress(RequestEntity $requestEntity): void
    {
        try {
            $response = $this->client->get("btc/main/addrs/{$requestEntity->getAddress()}");
            $this->data = $response->getBody()->getContents();
            // data looks like:
            // {
            //  "address": "1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD",
            //  "total_received": 4654010,
            //  "total_sent": 0,
            //  "balance": 4654010,
            //  "unconfirmed_balance": 0,
            //  "final_balance": 4654010,
            //  "n_tx": 16,
            //  "unconfirmed_n_tx": 0,
            //  "final_n_tx": 16,
            //  "txrefs": [
            //    {
            //      "tx_hash": "2684c187196bb5dc22cafb8f54825f2499fbf3912472a93c7f293a624e599977",
            //      "block_height": 651522,
            //      "tx_input_n": -1,
            //      "tx_output_n": 0,
            //      "value": 18682,
            //      "ref_balance": 4654010,
            //      "spent": false,
            //      "confirmati'... (length=5950)
        } catch (ClientException $e) {
            throw $this->transformClientException($e);
        } catch (RequestException $e) {
            $responseData = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : '';
            $message = sprintf(
                "Failed request\n> Code: %d\n> Message: %s\n> Response",
                $e->getCode(),
                $e->getMessage(),
                $responseData
            );

            throw new EndpointClientException($message);
        } catch (TransferException $e) {
            throw new EndpointClientException(
                sprintf("Failed request\n> Code: %d\n> Message: %s", $e->getCode(), $e->getMessage())
            );
        }
    }

    public function storeData(RequestEntity $requestEntity): void
    {
        // since we trust the source we do not need a validation process here
        // it would be just DTO and a mapping + storing procedure
        // since we already stored incoming request data in the Controller we can suggest here would be smth similar...
    }
}