<?php

return [
    // slackのwebhook urlを記述します
    'url' => env('SLACK_WEBHOOK_URL'),

    // slackのチャンネル名を記述します
    'channel' => 'incident',

    //
    'username' => 'Laravel Log',
    'emoji' => ':boom:',
    'level' => 'critical',
];
