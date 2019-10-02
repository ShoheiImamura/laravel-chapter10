<?php
declare(strict_types=1);

namespace App\Providers;

use Fluent\Logger\FluentLogger;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Log\Writer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FluentLogger::class, function () {
            // 実際に利用する場合は.envファイルなどでサーバのアドレス、portを指定してください
            return new FluentLogger('localhost', 24224);
        });


        if ($this->app->runningInConsole()) {
            $this->app->singleton('log', function (Application $app) {

                $logger = new Writer(
                    new \Monolog\Logger($app->environment()),
                    $app[Dispatcher::class]
                );
                // storages/log/console.logファイルとして出力します
                $logger->useDailyFiles(
                    storage_path('logs/console.log'),
                    // config/app.phpに記載されている内容を使ってログファイルの保持期間を指定します。
                    // config/app.phpにlog_max_filesがない場合は5日間をデフォルトとしています。
                    $app['config']->get('app.log_max_files', 5)
                    // 上記の設定をすることでファイル名は、console-YYYY-MM-DD.logとなります
                );
                return $logger;
            });
        }
    }
}
