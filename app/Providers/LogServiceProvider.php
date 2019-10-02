<?php
declare(strict_types=1);

namespace App\Providers;

use Illuminate\Log\Writer;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;
use Monolog\Handler\SlackWebhookHandler;

// デフォルトのAppServiceProviderを利用しても構いません。
class LogServiceProvider extends ServiceProvider
{
    public function register()
    {
        // サービスコンテナのLogファサードの本体であるインスタンスを取得します。
        /** @var Writer $logger */
        $logger = $this->app[LoggerInterface::class];

        // Laravelが利用しているMonologのインスタンスを取得し、ログハンドラの追加を行ないます。
        $monolog = $logger->getMonolog();

        // config/slack.phpに設定ファイルを用意し、設定値を取得します。
        $config = $this->app['config']->get('slack');
        $monolog->pushHandler(new SlackWebhookHandler(
            $config['url'],
            $config['channel'] ?? null,
            $config['username'] ?? 'Laravel',
            $config['attachment'] ?? true,
            $config['emoji'] ?? ':boom:',
            $config['short'] ?? false,
            $config['context'] ?? true,
            \Monolog\Logger::CRITICAL
        ));
    }
}
