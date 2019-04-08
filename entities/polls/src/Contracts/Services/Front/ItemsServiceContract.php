<?php

namespace InetStudio\PollsPackage\Polls\Contracts\Services\Front;

use InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract;
use InetStudio\AdminPanel\Base\Contracts\Services\BaseServiceContract;

/**
 * Interface ItemsServiceContract.
 */
interface ItemsServiceContract extends BaseServiceContract
{
    /**
     * Голосуем в опросе.
     *
     * @param  int  $pollID
     * @param  int  $optionID
     *
     * @return PollModelContract|null
     */
    public function vote(int $pollID, int $optionID): ?PollModelContract;

    /**
     * Участвовал пользователь в опросе или нет.
     *
     * @param  int  $pollID
     *
     * @return array
     */
    public function isVote(int $pollID): array;
}
