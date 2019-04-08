<?php

namespace InetStudio\PollsPackage\Polls\Contracts\Http\Controllers\Front;

use Illuminate\Http\Request;
use InetStudio\PollsPackage\Polls\Contracts\Services\Front\ItemsServiceContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Front\VoteResponseContract;

/**
 * Interface ItemsControllerContract.
 */
interface ItemsControllerContract
{
    /**
     * Голосование в опросе.
     *
     * @param  ItemsServiceContract  $pollsService
     * @param  Request  $request
     *
     * @return VoteResponseContract
     */
    public function vote(
        ItemsServiceContract $pollsService,
        Request $request
    ): VoteResponseContract;
}
