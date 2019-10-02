# 第二部 Chapter 10 / アプリケーション運用

## ログ活用パターン

本節(10-2)では、Laravel 5.5 と 5.6 のログについて解説  
Laravel 5.5 と 5.6 では処理が変わる点があるので注意

### 公式ドキュメント（日本語）

- [Laravel 5.5 エラーとログ](https://readouble.com/laravel/5.5/ja/errors.html)
- [Laravel 5.6 ログ](https://readouble.com/laravel/5.6/ja/logging.html)
- [Laravel 6.0 ログ](https://readouble.com/laravel/6.0/ja/logging.html)

### ログドライバとログハンドラ

| 用語         | 説明                               |
|--------------|------------------------------------|
| ログハンドラ | ログをどのように扱うかをきめる処理 |
| ログドライバ | ログハンドラに対応する名前？       |

### ログの利用用途

- 障害検知
- 障害の原因究明
- データ分析 等...

### 使い方

```php
// Log ファサードを利用する
Log::info('Showing user profile for user: '.$id);

// logger ヘルパ関数を利用する
logger('User has logged in.', ['id' => $user->id]);
```

### Laravel のログ出力内容

| 項目     | 説明               | 型     |
|----------|--------------------|--------|
| 第１引数 | メッセージ         | 文字列 |
| 第２引数 | （任意の補足情報） | 配列   |

```php
// Log::{ログレベル}({メッセージ}, {任意の補足情報})
Log::info('User failed to login.', ['id' => $user->id]);

// 上記から出力されるログ
[2019-10-03 06:28:35] local.INFO : User failed to login. {'id': 100}
```

### ログの出力設定

- `/config/app.php` 内で設定する
- デフォルトは `single` 設定

```php
// チャンネルドライバの設定
'log' => env('APP_LOG', 'single'),

// ログレベルの設定
'log_level' => env('APP_LOG_LEVEL', 'debug'),
```

- バージョン 5.5 と 5.6 とで設定できる項目が変わっている

| 設定       | 説明                           | 対応 ver      |
|------------|--------------------------------|---------------|
| single     | シングルファイル               | 6.0, 5.6, 5.5 |
| daily      | 毎日ファイルを切り替える       | 6.0, 5.6, 5.5 |
| syslog     | linux のシステムログ           | 6.0, 5.6, 5.5 |
| errorlog   | php のエラーログ               | 6.0, 5.6, 5.5 |
| stack      | 「マルチチャンネル」を作成する | 6.0, 5.6      |
| slack      | slack へ通知する               | 6.0, 5.6      |
| custome    | カスタムチャンネルを定義       | 6.0, 5.6      |
| papertrail | papertrail を利用              | 6.0           |
| monolog    | Monologハンドラをどれでも使用  | 6.0, 5.6      |

### rsyslog によるログ集約

- `syslog` チャンネルは linux サーバの syslog として出力する
  - Laravel プロジェクト以外のログも混在する
  - サーバ構成が複数台の場合、ログが分散する

- rsyslog は syslog から Laravel アプリケーションのログを集約する
  - `/etc/rsyslog.conf` に設定内容を記述する
  - ログ出力先を任意のディレクトリや別サーバに設定できる

### Log 関連のクラス概観

- クラス名のみ
![](https://github.com/ShoheiImamura/laravel-chapter10/blob/master/.documents/%E3%82%AF%E3%83%A9%E3%82%B9%E5%9B%B3_%E3%82%B7%E3%83%B3%E3%83%97%E3%83%AB.png?raw=true)

- クラス名 + メソッド名
![](https://github.com/ShoheiImamura/laravel-chapter10/blob/master/.documents/%E3%82%AF%E3%83%A9%E3%82%B9%E5%9B%B3_%E3%83%A1%E3%82%BD%E3%83%83%E3%83%89%E8%A1%A8%E7%A4%BA.png?raw=true)

- laravel5.5 でWebhookHandlerを追加する場合
![](https://github.com/ShoheiImamura/laravel-chapter10/blob/master/.documents/%E3%82%AF%E3%83%A9%E3%82%B9%E5%9B%B3_SlackWebhook%E8%BF%BD%E5%8A%A0.png?raw=true)

- 権限に酔ってアプリケーションログを分離する場合
![](https://github.com/ShoheiImamura/laravel-chapter10/blob/master/.documents/%E3%82%AF%E3%83%A9%E3%82%B9%E5%9B%B3_%E3%82%A2%E3%83%97%E3%83%AA%E3%82%B1%E3%83%BC%E3%82%B7%E3%83%A7%E3%83%B3%E3%83%AD%E3%82%B0%E5%88%86%E9%9B%A2.png?raw=true)

- Elastic ドライバを追加する場合
![](https://github.com/ShoheiImamura/laravel-chapter10/blob/master/.documents/%E3%82%AF%E3%83%A9%E3%82%B9%E5%9B%B3_ElasticaDriver%E8%BF%BD%E5%8A%A0.png?raw=true)



## 対応表

 - [リスト10.1.4.2：Fluent\Logger\FluentLoggerクラスの登録](app/Providers/AppServiceProvider.php)
 - [リスト10.1.4.3：例外をFluentdに送信する](app/Exceptions/Handler.php)
 - [リスト10.1.5.3：カスタムヘッダを利用したエラーレスポンス実装例](app/Exceptions/Handler.php)
 - [リスト10.1.6.1：Bladeテンプレートと例外処理組み合わせパターン例](app/Exceptions/AppException.php)
 - [リスト10.1.6.2：例外処理とレスポンスを結び付ける例](app/Http/Controllers/Exception/BladeRenderAction.php)
 - [リスト10.1.6.3：JSONレスポンスと例外処理組み合わせパターン例](app/Exceptions/UserResourceException.php)
 - [リスト10.2.2.7：SlackWebhookHandlerの追加例（ Laravel 5.5以前の場合）](app/Providers/LogServiceProvider.php)
 - [リスト10.2.3.1：コンソールアプリケーションのログを分離する](app/Providers/AppServiceProvider.php)
 - [リスト10.2.3.2：アプリケーションログ分離例](app/Providers/ExtendLogServiceProvider.php)
 - [リスト10.2.4.3：Elastica\Clientクラスのインスタンス生成方法を記述](app/Providers/ElasticaServiceProvider.php)
 - [リスト10.2.6.1：createElasticaDriverメソッド実装例](app/Foundation/Logger/Writer.php)
 - [リスト10.2.6.3：LogServiceProviderクラスの拡張](app/Providers/ExtendLogServiceProvider.php)
 - [リスト10.2.6.4：アクセスログをControllerクラスからelasticsearchに送信する](app/Http/Controllers/IndexAction.php)
 
## For Docker

### setup 

```bash
$ docker-compose up -d
$ docker-compose run composer install --prefer-dist --no-interaction && composer app-setup
```

### down

```bash
$ docker-compose down
```

### コンテナのキャッシュが残っている場合

```bash
$ docker-compose build --no-cache
```
