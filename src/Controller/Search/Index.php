<?php

namespace University\WebScraper\Controller\Search;

use Elasticsearch\Client;
use Slim\Slim;
use University\WebScraper\Controller\AbstractController;

class Index extends AbstractController
{
    protected $template = 'search/index.html';

    /**
     * @var Client
     */
    private $client;

    public function __construct(Slim $slim, Client $client)
    {
        parent::__construct($slim);
        $this->client = $client;
    }

    public function execute()
    {
        $this->_isAllowed();
        $this->populatePageTitle('Search articles :)');

        $params = [
            'index' => 'pt-project',
            'body' => [
                //                'query' => [
                //                    'match' => [
                //                        'tags' => 'senat',
                //                    ],
                //                ],
                'aggs' => [
                    'tags' => [
                        'terms' => [
                            'field' => 'tags.keyword',
                        ],
                    ],
                ],
            ],
        ];

        $response = $this->client->search($params);

        $found = $response['hits']['total'];
        $docs = $response['hits']['hits'];

        $tags = $response['aggregations']['tags']['buckets'];

        $this->slim->render(
            $this->template,
            [
                'tags' => $tags,
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
