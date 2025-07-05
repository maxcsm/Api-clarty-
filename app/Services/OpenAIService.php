<?php

namespace App\Services;

use GuzzleHttp\Client;

class OpenAIService
{
    protected $apiKey;
    protected $client;

    public function __construct()
    {
        $this->apiKey = env('OPENAI_API_KEY'); // clé API dans .env
        $this->client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'timeout'  => 10.0,
            'headers' => [
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type'  => 'application/json',
            ],
        ]);
    }

    /**
     * Génère un embedding OpenAI pour un texte donné
     */
    public function embed(string $text): array
    {
        $response = $this->client->post('embeddings', [
            'json' => [
                'model' => 'text-embedding-3-large', // adapte selon ta config
                'input' => $text,
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        return $data['data'][0]['embedding'] ?? [];
    }
}