<?php

namespace InetStudio\PollsPackage\Votes\Contracts\Services\Front;

use InetStudio\PollsPackage\Votes\Contracts\Models\PollVoteModelContract;

/**
 * Interface PollsVotesServiceContract.
 */
interface PollsVotesServiceContract
{
    /**
     * Сохраняем модель.
     *
     * @param array $data
     * @param int $id
     *
     * @return PollVoteModelContract
     */
    public function save(array $data, int $id): PollVoteModelContract;
}
