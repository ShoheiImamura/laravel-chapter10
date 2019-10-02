<?php
declare(strict_types=1);

namespace App\Exceptions;

use Fluent\Logger\FluentLogger;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
        /*
        $fluentLogger = $this->container->make(FluentLogger::class);
        $fluentLogger->post('report', ['error' => $exception->getMessage()]);
        */
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // 送出されたExceptionクラスを継承したインスタンスのうち特定の例外のみ処理を変更
        if ($exception instanceof QueryException) {
            // カスタムヘッダを利用してエラーレスポンス、ステータスコード500を返却
            return new Response('', Response::HTTP_INTERNAL_SERVER_ERROR, [
                'X-App-Message' => 'An error occurred.'
            ]);
        }
        return parent::render($request, $exception);
    }
}
