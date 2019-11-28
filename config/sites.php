<?php

use University\WebScraper\Processor\Onet;

return [
    'https://wiadomosci.onet.pl/sitemap-news.xml' =>
        [
            'label' => 'wiadomosci.onet.pl',
            'processor' => Onet::class
        ],
];
