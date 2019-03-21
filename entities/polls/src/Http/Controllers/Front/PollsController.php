<?php

namespace InetStudio\PollsPackage\Polls\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\PollsPackage\Polls\Contracts\Services\Front\ItemsServiceContract;
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
     * @param Application $app
     * @param ItemsServiceContract $pollsService
     * @param Request $request
     *
     * @return VoteResponseContract
     */
    public function vote(Application $app,
                         ItemsServiceContract $pollsService,
                         Request $request): VoteResponseContract
    {
        $pollID = $request->get('id', 0);
        $optionID = $request->get('answer', 0);

        $item = $pollsService->vote($pollID, $optionID);

        return $app->make(VoteResponseContract::class, compact('item'));
    }
}
