<?php

namespace Chuva\Php\WebScrapping;

use Chuva\Php\WebScrapping\Entity\Paper;
use Chuva\Php\WebScrapping\Entity\Person;
use DOMXPath;

/**
 * Does the scrapping of a webpage.
 */
class Scrapper
{

    /**
     * Loads paper information from the HTML and returns the array with the data.
     */
    public function scrap(\DOMDocument $dom): array
    {
        $xpath = new DOMXPath($dom);
        $paperArray = [];
        $papers = $xpath->query('.//div//a[@class="paper-card p-lg bd-gradient-left"]');
        foreach ($papers as $paper) {
            $title = $xpath->query('.//h4[@class="my-xs paper-title"]', $paper)->item(0)->textContent;
            $type = $xpath->query('.//div[@class="tags mr-sm"]', $paper)->item(0)->textContent;
            $id = $xpath->query('.//div[@class="tags flex-row mr-sm"]//div/text()', $paper)->item(0)->textContent;
            $authorsNodes = $xpath->query('.//div[@class="authors"]//span', $paper);
            $authors = [];
            foreach ($authorsNodes as $authorNode) {
                $authors[] = new Person(
                    $authorNode->textContent,
                    $authorNode->getAttribute('title')
                );
            }

            $authorsAndInstitutions = [];
            foreach ($authors as $author) {
                $authorsAndInstitutions[] = [
                    'author' => $author->getName(),
                    'institution' => $author->getInstitution()
                ];
            }

            $paperArray[] = new Paper(
                $id,
                $title,
                $type,
                $authorsAndInstitutions
            );
        }
        return $paperArray;
    }

}
