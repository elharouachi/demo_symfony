<?php

namespace App\Controller;

use App\Http\JsonService;
use App\Http\RssService;
use App\Services\ImageLinkExtractor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Home extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return Response
     */
    public function __invoke(
        Request $request,
        RssService $rssService,
        JsonService $jsonService,
        ImageLinkExtractor $imageLinkExtractor
    )
    {
        $queryRss = '//img[contains(@class,"size-full")]/@src';
        $queryJson = '//img/@src';

        $jsonLink = $jsonService->getJsonLinks();
        $rsslink = $rssService->getRssLinks();


        $links = array_unique(array_merge($jsonLink, $rsslink), SORT_REGULAR);

        $images = [];

        foreach ($links as $link) {
            try {
                if (strstr($link, "commitstrip.com")) {
                    $images[] = $imageLinkExtractor->extractImageLink($link, $queryRss);
                } else {
                    $images[] = $imageLinkExtractor->extractImageLink($link, $queryJson);
                }
            } catch (\Exception $e) {
                //  TODO  Log the error
            }
        }

        return $this->render('default/index.html.twig', array('images' => $images))->setSharedMaxAge(3600);;
    }



}
