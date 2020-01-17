<?php

namespace University\WebScraper\Processor;

use PHPHtmlParser\Dom;

interface ProcessorInterface
{
    public function parseDom(Dom $dom): array;
}
