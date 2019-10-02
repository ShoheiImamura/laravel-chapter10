<?php
declare(strict_types=1);

namespace App\Http\Controllers\Exception;

use App\Exceptions\AppException;
use Illuminate\Contracts\View\Factory as View;

/**
 * Class BladeRenderAction
 */
final class BladeRenderAction
{
    /** @var View */
    private $view;

    /**
     * BladeRenderAction constructor.
     *
     * @param View $view
     */
    public function __construct(View $view)
    {
        $this->view = $view;
    }

    public function __invoke()
    {
        // helper関数利用
        throw new AppException(view('errors.page'), 'error.');

        // helper関数未利用
        // throw new AppException($this->view->make('errors.page'), 'error.');
    }
}
