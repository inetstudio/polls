<?php

namespace InetStudio\PollsPackage\Polls\Contracts\Services\Back;

use InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract;
use InetStudio\AdminPanel\Base\Contracts\Services\BaseServiceContract;

/**
 * Interface ItemsServiceContract.
 */
interface ItemsServiceContract extends BaseServiceContract
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
