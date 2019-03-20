<?php

namespace InetStudio\PollsPackage\Analytics\Contracts\Services\Back;

use InetStudio\AdminPanel\Base\Contracts\Services\BaseServiceContract;

/**
 * Interface AnalyticsServiceContract.
 */
interface AnalyticsServiceContract extends BaseServiceContract
{
    /**
     * Возвращаем статьи, в которых содержится опрос.
     *
     * @param int $id
     *
     * @return array
     */
    public function getArticlesWithPoll(int $id): array;
}
