<?php

namespace App\Http;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class JsonService
{
    private $rssUrl = null;
    private $client;

    public function __construct(HttpClientInterface $client, $jsonUrl)
    {
        $this->jsonUrl = $jsonUrl;
        $this->client = $client;
    }

    private function getJsonContent(): ?array
    {
        $response = $this->client->request(
            'GET',
            $this->jsonUrl
        );
        return $response->toArray();
    }

    public function getJsonLinks(): array
    {
        $links = [];
        $jsonContent = $this->getJsonContent();

        foreach ($jsonContent['articles'] as $article) {
            if( '' !== trim($article['url'])) {
                $links[] = trim($article['url']);
            }

        }

        return $links;
    }

}