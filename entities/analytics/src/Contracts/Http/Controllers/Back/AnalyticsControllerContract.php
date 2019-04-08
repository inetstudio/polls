<?php

namespace InetStudio\PollsPackage\Analytics\Contracts\Http\Controllers\Back;

use InetStudio\PollsPackage\Analytics\Contracts\Services\Back\AnalyticsServiceContract;
use InetStudio\PollsPackage\Analytics\Contracts\Services\Back\DataTableServiceContract;
use InetStudio\PollsPackage\Analytics\Contracts\Http\Responses\Back\IndexResponseContract;
use InetStudio\PollsPackage\Analytics\Contracts\Http\Responses\Back\ResultResponseContract;

/**
 * Interface AnalyticsControllerContract.
 */
interface AnalyticsControllerContract
{
    /**
     * Список объектов.
     *
     * @param  DataTableServiceContract  $dataTableService
     *
     * @return IndexResponseContract
     */
    public function index(DataTableServiceContract $dataTableService): IndexResponseContract;

    /**
     * Результаты опроса.
     *
     * @param  AnalyticsServiceContract  $analyticsService
     * @param  int  $id
     *
     * @return ResultResponseContract
     */
    public function getPollResult(
        AnalyticsServiceContract $analyticsService,
        int $id = 0
    ): ResultResponseContract;
}
