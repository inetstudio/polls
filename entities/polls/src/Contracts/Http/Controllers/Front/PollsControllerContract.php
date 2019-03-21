<?php

namespace InetStudio\PollsPackage\Polls\Contracts\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use InetStudio\PollsPackage\Polls\Contracts\Services\Front\ItemsServiceContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Front\VoteResponseContract;

/**
 * Interface PollsControllerContract.
 */
interface PollsControllerContract
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
                         Request $request): VoteResponseContract;
}
