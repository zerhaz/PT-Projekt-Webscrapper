<?php

use Slim\LogWriter;
use Slim\Slim;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

/* Magic AutoLoad */
require '../vendor/autoload.php';

/// Server Configuration
require '../config/slim.php';

/* Starting, configure Slim */
$app = new Slim($slimConf);

$logWriter = new LogWriter(fopen($slimConf['log.file'], 'ab'));

$app->config(
    [
        'view' => new Twig(),
        'log.writer' => $logWriter,
        'templates.path' => '../src/templates',
        'cookies.encrypt' => true,
    ]
);

$view = $app->view();
$view->parserOptions = [
    'debug' => $slimConf['debug'],
    'cache' => $slimConf['cache.path'],
];

$view->parserExtensions = [
    new TwigExtension(),
];

$view->set(
    'app',
    [
        'uri' => $app->request->getUrl(),
    ]
);

require_once __DIR__ . '/../app/bootstrap.router.php';

$app->run();
