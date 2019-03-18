<?php

namespace InetStudio\PollsPackage\Analytics\Contracts\Services\Back;

use InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract;

/**
 * Interface AnalyticsServiceContract.
 */
interface AnalyticsServiceContract
{
    /**
     * Возвращаем статьи, в которых содержится опрос.
     *
     * @param int $id
     *
     * @return array
     */
    public function getArticlesWithPoll(int $id): array;

    /**
     * Получаем объект по id.
     *
     * @param mixed $id
     * @param array $params
     *
     * @return PollModelContract
     */
    public function getItemById($id = 0, array $params = []);
}
