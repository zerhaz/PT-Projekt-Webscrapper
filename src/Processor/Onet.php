<?php

namespace University\WebScraper\Processor;

use PHPHtmlParser\Dom;

class Onet implements ProcessorInterface
{
    public function parseDom(Dom $dom): array
    {
        $output = [];
        if ($dom) {
            // Title
            $articleTitle = $dom->find('h1.mainTitle');
            $output['title'] = filter_var(
                trim(strip_tags(html_entity_decode(htmlentities($articleTitle[0])))),
                FILTER_SANITIZE_STRING
            );

            // Body
            $articleBody = $dom->find('.articleBody');
            $output['body'] = trim(strip_tags($articleBody[0]));

            // Tags
            $articleCategories = $dom->find('span.relatedTopic');

            $tags = [];
            foreach ($articleCategories as $articleCategory) {
                $tags[] = ucfirst(trim(str_replace(',', '', strip_tags($articleCategory))));
            }

            $output['tags'] = $tags;
        }

        return $output;
    }
}
