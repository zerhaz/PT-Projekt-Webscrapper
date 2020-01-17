<?php

use Elasticsearch\ClientBuilder;
use University\WebScraper\Controller\Search\Index;
use University\WebScraper\Controller\Search\Result;

$client = ClientBuilder::create()->build();


    $class = new Index($app, $client);
    $app->get('/', array($class, 'execute'));
    $app->get('/index', array($class, 'execute'))->setName('homepage');


$app->group(
    '/search', function () use ($app, $client){

    $class = new Result($app, $client);
    $app->get('/result', array($class, 'execute'));

});


