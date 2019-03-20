<?php

namespace InetStudio\PollsPackage\Options\Contracts\Services\Back;

use Illuminate\Support\Collection;
use InetStudio\AdminPanel\Base\Contracts\Services\BaseServiceContract;
use InetStudio\PollsPackage\Options\Contracts\Models\PollOptionModelContract;

/**
 * Interface ResourceServiceContract.
 */
interface ResourceServiceContract extends BaseServiceContract
{
    /**
     * Сохраняем модель.
     *
     * @param array $data
     * @param int $id
     *
     * @return PollOptionModelContract
     */
    public function save(array $data, int $id): PollOptionModelContract;

    /**
     * Сохраняем массив моделей.
     *
     * @param $data
     *
     * @return Collection
     */
    public function saveCollection($data): Collection;
}
