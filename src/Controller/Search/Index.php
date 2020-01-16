<?php

namespace University\WebScraper\Controller\Search;

use Elasticsearch\Client;
use Slim\Slim;
use University\WebScraper\Controller\AbstractController;

class Index extends AbstractController
{
    protected $template = 'search/index.html';

    public function __construct(Slim $slim, Client $client)
    {
        parent::__construct($slim);
    }

    public function execute()
    {
        $this->_isAllowed();
        $this->populatePageTitle('Search articles :)');

        $this->slim->render(
            $this->template,
            [

            ]
        );
    }

    public function _isAllowed()
    {
        return true;
    }

    public function controllerName(): string
    {
        return 'Search::Index';
    }

    public function controllerType(): string
    {
        return parent::TYPE_GET;
    }

    public function controllerBeforeParams()
    {
        // TODO: Implement controllerBeforeParams() method.
    }

    public function controllerAfterParams()
    {
        // TODO: Implement controllerAfterParams() method.
    }
}
