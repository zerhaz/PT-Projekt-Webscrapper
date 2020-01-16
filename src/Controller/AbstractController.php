<?php

namespace University\WebScraper\Controller;

use Slim\Slim;

abstract class AbstractController
{
    const TYPE_GET = 'get';
    const TYPE_POST = 'post';
    const TYPE_PUT = 'put';
    const TYPE_DELETE = 'delete';

    protected $slim;

    public function __construct(Slim $slim)
    {
        $this->slim = $slim;
    }

    public function populatePageTitle(string $title)
    {
        $this->slim->view()->set('pageTitle', $title);
    }

    public abstract function _isAllowed();

    public abstract function controllerName(): string;

    public abstract function controllerType(): string;

    public abstract function controllerBeforeParams();

    public abstract function controllerAfterParams();
}
