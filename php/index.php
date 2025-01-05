<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class PineapplePayClient
{
    private const BASE_URL = 'https://api.pineapplepay.co';
    private string $clientId;
    private string $clientSecret;
    private Client $httpClient;

    /**
     * Construtor para inicializar credenciais e client HTTP.
     */
    public function __construct(string $clientId, string $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->httpClient = new Client([
            'base_uri' => self::BASE_URL,
            'headers'  => [
                'Content-Type'    => 'application/json',
                'x-client-id'     => $this->clientId,
                'x-client-secret' => $this->clientSecret,
            ],
        ]);
    }

    /**
     * Método para criar transação (Payment).
     *
     * @param array $data Exemplo de estrutura:
     * [
     *   'name'        => 'Fulano de Tal',
     *   'email'       => 'fulano@example.com',
     *   'document'    => '00000000000',
     *   'description' => 'Serviço X',
     *   'amount'      => 1000,
     *   'postbackUrl' => 'https://minhaurl.com/postback'
     * ]
     */
    public function createTransaction(array $data): ?array
    {
        try {
            $response = $this->httpClient->post('/v1/payment', [
                'json' => $data,
            ]);
            $body = json_decode($response->getBody()->getContents(), true);
            return $body;
        } catch (GuzzleException $e) {
            // Trate o erro de acordo com sua necessidade, logs, etc.
            return null;
        }
    }

    /**
     * Método para estornar transação (Refund).
     *
     * @param array $data Exemplo de estrutura:
     * [
     *   'transactionId' => 'abc123',
     *   'description'   => 'Motivo do estorno'
     * ]
     */
    public function refundTransaction(array $data): ?array
    {
        try {
            $response = $this->httpClient->post('/v1/refund', [
                'json' => $data,
            ]);
            $body = json_decode($response->getBody()->getContents(), true);
            return $body;
        } catch (GuzzleException $e) {
            // Trate o erro de acordo com sua necessidade, logs, etc.
            return null;
        }
    }

    /**
     * Método para buscar transação.
     *
     * @param string $id ID da transação
     */
    public function getTransaction(string $id): ?array
    {
        try {
            $response = $this->httpClient->get("/v1/payment/{$id}");
            $body = json_decode($response->getBody()->getContents(), true);
            return $body;
        } catch (GuzzleException $e) {
            // Trate o erro de acordo com sua necessidade, logs, etc.
            return null;
        }
    }

    /**
     * Método para fazer transferência (Withdraw).
     *
     * @param array $data Exemplo de estrutura:
     * [
     *   'amount'      => 1000,
     *   'name'        => 'Fulano de Tal',
     *   'document'    => '00000000000',
     *   'description' => 'Transferência para Fulano',
     *   'key'         => 'fulano@exemplo.com',
     *   'keyType'     => 'email'
     * ]
     */
    public function makeTransfer(array $data): ?array
    {
        try {
            $response = $this->httpClient->post('/v1/withdraw', [
                'json' => $data,
            ]);
            $body = json_decode($response->getBody()->getContents(), true);
            return $body;
        } catch (GuzzleException $e) {
            // Trate o erro de acordo com sua necessidade, logs, etc.
            return null;
        }
    }
}
