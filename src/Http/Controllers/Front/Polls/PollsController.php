<?php

namespace InetStudio\Polls\Http\Controllers\Front\Polls;

use App\Http\Controllers\Controller;
use InetStudio\Polls\Contracts\Http\Controllers\Front\Polls\PollsControllerContract;

/**
 * Class PollsController.
 */
class PollsController extends Controller implements PollsControllerContract
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    protected $services;

    /**
     * PollsController constructor.
     */
    public function __construct()
    {
        $this->services['polls'] = app()->make('InetStudio\Polls\Contracts\Services\Front\Polls\PollsServiceContract');
    }

    public function vote(Request $request): string
    {
        $type = ($request->filled('type')) ? strtolower(trim($request->get('type'))) : '';
        $id = ($request->filled('id')) ? (int)($request->get('id')) : '';

        if ($type != 'poll') {
            return '';
        }

        $poll = $this->services['pollsService']->vote($request, $id);

        return view('front.ajax.pollResult', [
            'poll' => $poll,
        ])->render();
    }
}
