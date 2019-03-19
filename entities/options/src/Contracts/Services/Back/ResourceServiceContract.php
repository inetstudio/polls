<?php

namespace InetStudio\PollsPackage\Options\Contracts\Services\Back;

use Illuminate\Support\Collection;
use InetStudio\PollsPackage\Options\Contracts\Models\PollOptionModelContract;

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

    /**
     * Удаляем модель.
     *
     * @param mixed $id
     *
     * @return bool|null
     */
    public function destroy($id): ?bool;
}
