<?php

namespace InetStudio\PollsPackage\Votes\Contracts\Services\Front;

use InetStudio\AdminPanel\Base\Contracts\Services\BaseServiceContract;
use InetStudio\PollsPackage\Votes\Contracts\Models\PollVoteModelContract;

/**
 * Interface ItemsServiceContract.
 */
interface ItemsServiceContract extends BaseServiceContract
{
    /**
     * Сохраняем модель.
     *
     * @param  array  $data
     * @param  int  $id
     *
     * @return PollVoteModelContract
     */
    public function save(array $data, int $id): PollVoteModelContract;
}
