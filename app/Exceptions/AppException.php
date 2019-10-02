<?php
declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use RuntimeException;

final class AppException extends RuntimeException implements Responsable
{
    /** @var string */
    protected $error = 'error';

    /** @var View */
    private $factory;

    /**
     * AppException constructor.
     *
     * @param View           $factory
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(
        View $factory,
        string $message = "",
        int $code = 0,
        Throwable $previous = null
    ) {
        $this->factory = $factory;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function toResponse($request): Response
    {
        return new Response(
            $this->factory->with($this->error, $this->message)
        );
    }
}
