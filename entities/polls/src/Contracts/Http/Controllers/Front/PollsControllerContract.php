<?php

namespace InetStudio\PollsPackage\Polls\Contracts\Http\Controllers\Front;

use Illuminate\Http\Request;
use InetStudio\PollsPackage\Polls\Contracts\Services\Front\PollsServiceContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Front\VoteResponseContract;

/**
 * Interface PollsControllerContract.
 */
interface PollsControllerContract
{
    /**
     * Голосование в опросе.
     *
     * @param PollsServiceContract $pollsService
     * @param Request $request
     *
     * @return VoteResponseContract
     */
    public function vote(PollsServiceContract $pollsService, Request $request): VoteResponseContract;
}
