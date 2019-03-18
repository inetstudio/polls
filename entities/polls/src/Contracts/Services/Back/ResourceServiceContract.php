<?php

namespace InetStudio\PollsPackage\Polls\Contracts\Services\Back;

use InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract;

/**
 * Interface ResourceServiceContract.
 */
interface ResourceServiceContract
{
    /**
     * Сохраняем модель.
     *
     * @param array $data
     * @param int $id
     *
     * @return PollModelContract
     */
    public function save(array $data, int $id): PollModelContract;
}
