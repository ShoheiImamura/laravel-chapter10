<?php
declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Elastica\Client;
use Illuminate\Log\Writer;
use App\Foundation\Logger\Writer as AppWriter;
use Monolog\Logger;

class ElasticaServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Client::class, function (Application $app) {
            // config/elastica.phpから値を取得します。
            $config = $app['config']->get('elastica');
            // 設定ファイルに記述されているservers配列をElastica\Clientクラスの引数に渡します。
            return new Client([
                'servers' => $config['servers']
            ]);
        });
    }
}

