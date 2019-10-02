<?php
declare(strict_types=1);

namespace App\Providers;

use Illuminate\Log\Writer;
use Elastica\Client;
use App\Foundation\Logger\Writer as AppWriter;
use Monolog\Logger;

class ExtendLogServiceProvider extends \Illuminate\Log\LogServiceProvider
{
    protected function filePath(): string
    {
        if ($this->app->runningInConsole()) {
            return $this->app->storagePath() . '/logs/console.log';
        }
        return $this->app->storagePath() . '/logs/laravel.log';
    }

    protected function configureSingleHandler(Writer $log)
    {
        $log->useFiles(
            $this->filePath(),
            $this->logLevel()
        );
    }

    protected function configureDailyHandler(Writer $log)
    {
        $log->useDailyFiles(
            $this->filePath(),
            $this->logLevel()
        );
    }

    public function createLogger()
    {
        // Illuminate\Log\Writerクラスを拡張したクラスを利用します
        $log = new AppWriter(
            new Logger($this->channel()), $this->app['events']
        );
        if ($this->app->hasMonologConfigurator()) {
            call_user_func($this->app->getMonologConfigurator(), $log->getMonolog());
        } else {
            $this->configureHandler($log);
        }
        return $log;
    }

    // config/app.phpで、logにelasticaと指定できる様にするためのメソッドを用意します
    protected function configureElasticaHandler(AppWriter $log)
    {
        // config/app.phpに追加した設定値を利用します
        $config = $this->app['config']->get('app');
        $log->useElastica(
            // サービスコンテナに登録したElastica\Clientインスタンスを取得して利用します。
            $this->app->make(Client::class), [
                'index' => $config['log_index'],
                'type'  => $config['log_type']
            ]
        );
    }
}
