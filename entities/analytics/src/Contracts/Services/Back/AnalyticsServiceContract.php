<?php

namespace InetStudio\PollsPackage\Analytics\Contracts\Services\Back;

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
}
