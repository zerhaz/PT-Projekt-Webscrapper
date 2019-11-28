<?php

use Symfony\Component\Console\Application;
use University\WebScraper\Console\Command\Pull;

require_once __DIR__ . '/../app/bootstrap.php';

// Build Console Application
$application = new Application();
$application->add(new Pull($sites));
$application->run();
