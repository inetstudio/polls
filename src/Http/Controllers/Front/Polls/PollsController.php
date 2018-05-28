<?php

namespace InetStudio\Polls\Http\Controllers\Front\Polls;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use InetStudio\Polls\Contracts\Http\Responses\Front\Polls\VoteResponseContract;
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

    /**
     * Голосование в опросе.
     *
     * @param Request $request
     *
     * @return VoteResponseContract
     */
    public function vote(Request $request): VoteResponseContract
    {
        $pollID = $request->get('id') ?? 0;
        $optionID = $request->get('answer') ?? 0;

        $item = $this->services['polls']->vote($pollID, $optionID);

        return app()->makeWith('InetStudio\Polls\Contracts\Http\Responses\Front\Polls\VoteResponseContract', [
            'item' => $item,
        ]);
    }
}
