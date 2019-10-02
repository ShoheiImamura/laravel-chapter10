<?php
declare(strict_types=1);

namespace App\Foundation\Logger;

use Elastica\Client;
use Monolog\Formatter\ElasticaFormatter;
use Monolog\Handler\ElasticSearchHandler;

class Writer extends \Illuminate\Log\Writer
{
    // このメソッドはIlluminate\Log\LogServiceProviderクラスを継承したクラスのメソッドから利用します。
    public function useElastica(Client $client, array $options, $level = 'debug')
    {
        $this->monolog->pushHandler($handler = new ElasticSearchHandler(
            $client,
            [],
            $this->parseLevel($level)
        ));
        $handler->setFormatter(
            new ElasticaFormatter($options['index'], $options['type'])
        );
    }
}
