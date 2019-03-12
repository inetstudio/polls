<?php

namespace InetStudio\PollsPackage\Polls\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use InetStudio\PollsPackage\Polls\Contracts\Services\Front\PollsServiceContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Front\VoteResponseContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Controllers\Front\PollsControllerContract;

/**
 * Class PollsController.
 */
class PollsController extends Controller implements PollsControllerContract
{
    /**
     * Голосование в опросе.
     *
     * @param PollsServiceContract $pollsService
     * @param Request $request
     *
     * @return VoteResponseContract
     */
    public function vote(PollsServiceContract $pollsService, Request $request): VoteResponseContract
    {
        $pollID = $request->get('id', 0);
        $optionID = $request->get('answer', 0);

        $item = $pollsService->vote($pollID, $optionID);

        return app()->makeWith(VoteResponseContract::class, compact('item'));
    }
}
