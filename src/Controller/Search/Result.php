<?php

namespace University\WebScraper\Controller\Search;

use Elasticsearch\Client;
use Slim\Slim;
use University\WebScraper\Controller\AbstractController;

class Result extends AbstractController
{
    protected $template = 'search/result.html';

    /**
     * @var Client
     */
    private $client;

    /**
     * Result constructor.
     *
     * @param Slim $slim
     * @param Client $client
     */
    public function __construct(Slim $slim, Client $client)
    {
        parent::__construct($slim);
        $this->client = $client;
    }

    public function execute()
    {
        $request = $this->slim->request;

        $tags = $request->get('tags');
        $query = $request->get('query');


        if ($tags == '' && $query == ''){
            $this->slim->redirectTo('homepage');
        }
        $params = [];
        if ($tags != '' && $query != '') {
            $params = [
                'index' => 'pt-project',
                'body' => [
                    'query' =>
                        [
                            'bool' => [
                                'must' => [
                                    ['match' => ['tags' => $tags]],
                                    [
                                        'bool' => [
                                            'should' => [
                                                ['term' => ['title' => $query]],
                                                ['term' => ['body' => $query]],
                                            ],
                                        ],
                                    ],
                                ],

                            ],
                        ],
                ],
            ];
        } elseif ($tags != '') {
            $params = [
                'index' => 'pt-project',
                'body' => [
                    'query' =>
                        [
                            'bool' => [
                                'must' => [
                                    ['match' => ['tags' => $tags]],
                                ],
                            ],
                        ],
                ],
            ];
        } elseif ($query != '') {
            $params = [
                'index' => 'pt-project',
                'body' => [
                    'query' =>
                        [
                            'bool' => [
                                'must' => [
                                    ['match' => ['body' => $query]],
                                ],
                            ],
                        ],
                ],
            ];
        }

        $response = $this->client->search($params);

        $found = $response['hits']['total'];
        $docs = $response['hits']['hits'];

        $this->slim->render(
            $this->template,
            [
                'found' => $found,
                'result' => $docs,
            ]
        );
    }

    public function _isAllowed()
    {
        return true;
    }

    public function controllerName(): string
    {
        return 'Search::Result';
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
