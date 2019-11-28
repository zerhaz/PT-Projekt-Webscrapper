<?php

namespace University\WebScraper\Console\Command;

use Elasticsearch\ClientBuilder;
use PHPHtmlParser\Dom;
use SimpleXMLElement;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use University\WebScraper\Processor\Onet;

class Pull extends Command
{
    /**
     * @var array
     */
    private $sites;

    /**
     * Pull constructor.
     *
     * @param array $sites
     * @param string|null $name
     */
    public function __construct(array $sites, string $name = null)
    {
        parent::__construct($name);
        $this->sites = $sites;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = ClientBuilder::create()->build();
        $pagesToSearch = [];
        foreach ($this->sites as $url => $details) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data = curl_exec($ch);

            $xml = new SimpleXMLElement($data);
            foreach ($xml->url as $url) {
                $loc = $url->loc;
                $pagesToSearch[] = [
                    'url' => (string) $loc,
                    'config' => $details,
                ];

                $dom = new Dom;
                try {
                    $url = (string) $loc;
                    $output->writeln(sprintf('Start download content from: %s.', $url));
                    $dom->loadFromUrl($url);

                    /** @var Onet $processor */
                    $processor = new $details['processor']();
                    $params = [
                        'index' => 'pt-project',
                        'id' => urlencode($url),
                        'body' => $processor->parseDom($dom),
                    ];

                    $response = $client->index($params);
                } catch (\PHPHtmlParser\Exceptions\ChildNotFoundException $e) {
                } catch (\PHPHtmlParser\Exceptions\CircularException $e) {
                } catch (\PHPHtmlParser\Exceptions\CurlException $e) {
                } catch (\PHPHtmlParser\Exceptions\StrictException $e) {
                }

            }
            curl_close($ch);
        }
    }

    protected function configure()
    {
        $this->setName('app:pull:all')
            ->setDescription('Pull all data from configuration and send it to dedicated adapter.')
            ->setHelp('This command allows you to start test based on latest site maps...');
    }
}