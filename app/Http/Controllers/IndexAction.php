<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;

final class IndexAction extends Controller
{
    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(Request $request)
    {
        $this->logger->info('user.action', [
            'uri'     => $request->getUri(),
            'referer' => $request->headers->get('referer', ''),
            'user_id' => 1,
            'query'   => $request->query->all()
        ]);
        // Logファサード、またはloggerヘルパー関数も利用できます。
        logger()->info('user.action', [
            'uri'     => $request->getUri(),
            'referer' => $request->headers->get('referer', ''),
            'user_id' => 1,
            'query'   => $request->query->all()
        ]);
        return response()->json(['message' => 'testing']);
    }
}
