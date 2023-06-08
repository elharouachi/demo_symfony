<?php

namespace App\Http;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class RssService
{
    private $rssUrl = null;
    private $client;
    private const IMAGE_EXTENSIONS = ['jpg', 'gif', 'png'];

    public function __construct(HttpClientInterface $client, $rssUrl)
    {
        $this->rssUrl = $rssUrl;
        $this->client = $client;
    }

    private function getRssContent(): ?string
    {
        $response = $this->client->request(
            'GET',
            $this->rssUrl,
            [
                'headers' => [
                    'Accept' => 'application/rss+xml',
                ],
            ]
        );
        return $response->getContent();
    }

    public function getRssLinks(): array
    {
        $i = 0;
        $links = [];
        $rssContent = $this->getRssContent();
        $rssXmlContent = simplexml_load_string($rssContent, 'SimpleXMLElement', LIBXML_NOCDATA);
        $channel = $rssXmlContent->channel;
        $countItems = count($channel->item);

        foreach ($channel->item as $item) {
            $links[]= (string)$item->link[0];

            foreach (self::IMAGE_EXTENSIONS as $extension) {
                if(!!substr_count(strtoupper((string)$item[$i]->children("content", true)), $extension) < 0)  {
                    $links[] = "";
                }
            }
            $i++;
        }

        return $links;
    }
}