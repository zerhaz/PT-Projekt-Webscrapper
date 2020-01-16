<?php

$app->group(
    '/', function () use ($app) {

    $class = new \University\WebScraper\Controller\Search\Index($app);
    $app->get('/', array($class, 'execute'));
    $app->get('/index', array($class, 'execute'));
});
