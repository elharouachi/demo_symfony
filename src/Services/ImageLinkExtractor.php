<?php

namespace App\Services;

class ImageLinkExtractor
{
    public function extractImageLink($image, $query)
    {
        $doc = new \DomDocument();
        @$doc->loadHTMLFile($image);
        $xpath = new \DomXpath($doc);
        $xq = $xpath->query($query);
        $src=$xq[0]->value;

        return $src;
    }
}