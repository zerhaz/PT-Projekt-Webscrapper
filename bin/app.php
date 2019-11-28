<?php

use Elasticsearch\ClientBuilder;
use PHPHtmlParser\Dom;

require_once __DIR__ . '/../vendor/autoload.php';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
curl_close($ch);

$pagesToSearch = [];
$xml = new SimpleXMLElement($data);
foreach ($xml->url as $url) {
    $loc = $url->loc;
    $pagesToSearch[] = (string) $loc;
}

$data = [];
foreach ($pagesToSearch as $url) {


    // TODO: Foreach processors
    $data[] = [
        'url' => $url
    ];

}





