<?php

namespace InetStudio\PollsPackage\Polls\Contracts\Services\Back;

use InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract;

/**
 * Interface ResourceServiceContract.
 */
interface ResourceServiceContract
{
    /**
     * Получаем объект по id.
     *
     * @param mixed $id
     * @param array $params
     *
     * @return PollModelContract
     */
    public function getItemById($id = 0, array $params = []);

    /**
     * Сохраняем модель.
     *
     * @param array $data
     * @param int $id
     *
     * @return PollModelContract
     */
    public function save(array $data, int $id): PollModelContract;

    /**
     * Сохраняем модель.
     *
     * @param array $data
     * @param int $id
     *
     * @return PollModelContract
     */
    public function saveModel(array $data, int $id = 0);

    /**
     * Удаляем модель.
     *
     * @param mixed $id
     *
     * @return bool|null
     */
    public function destroy($id): ?bool;
}
