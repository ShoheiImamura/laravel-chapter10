<?php

return [
    'servers' => [
        [
            // elasticsearchのhostを環境に合わせて指定してください
            'host' => env('ELASTICSEARCH_HOST', '127.0.0.1'),
            'port' => env('ELASTICSEARCH_PORT', 9200),
        ],
    ]
];
