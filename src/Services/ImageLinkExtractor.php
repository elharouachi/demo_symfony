<?php

namespace App\Services;

class ImageLinkExtractor
{

    public function rssExtractImageLink()
    {
        $doc = new \DomDocument();
        @$doc->loadHTMLFile($l);
        $xpath = new \DomXpath($doc);
        $xq = $xpath->query('//img[contains(@class,"size-full")]/@src');
        $src=$xq[0]->value;

        return $src;
    }

    public function extractImageLink($image, $query)
    {
        $doc = new \DomDocument();
        @$doc->loadHTMLFile($image);
        $xpath = new \DomXpath($doc);
        $xq = $xpath->query('//img/@src');
        $src=$xq[0]->value;

        return $src;
    }
}