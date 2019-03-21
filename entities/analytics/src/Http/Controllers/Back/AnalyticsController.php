<?php

namespace InetStudio\PollsPackage\Analytics\Http\Controllers\Back;

use Illuminate\Contracts\Foundation\Application;
use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\PollsPackage\Analytics\Contracts\Services\Back\AnalyticsServiceContract;
use InetStudio\PollsPackage\Analytics\Contracts\Services\Back\DataTableServiceContract;
use InetStudio\PollsPackage\Analytics\Contracts\Http\Responses\Back\IndexResponseContract;
use InetStudio\PollsPackage\Analytics\Contracts\Http\Responses\Back\ResultResponseContract;
use InetStudio\PollsPackage\Analytics\Contracts\Http\Controllers\Back\AnalyticsControllerContract;

/**
 * Class AnalyticsController.
 */
class AnalyticsController extends Controller implements AnalyticsControllerContract
{
    /**
     * Список объектов.
     *
     * @param Application $app
     * @param DataTableServiceContract $dataTableService
     *
     * @return IndexResponseContract
     */
    public function index(Application $app,
                          DataTableServiceContract $dataTableService): IndexResponseContract
    {
        $table = $dataTableService->html();

        return $app->make(IndexResponseContract::class, [
            'data' => compact('table'),
        ]);
    }

    /**
     * Результаты опроса.
     *
     * @param Application $app
     * @param AnalyticsServiceContract $analyticsService
     * @param int $id
     *
     * @return ResultResponseContract
     *
     * @throws \Throwable
     */
    public function getPollResult(Application $app,
                                  AnalyticsServiceContract $analyticsService,
                                  int $id = 0): ResultResponseContract
    {
        $item = $analyticsService->getItemById($id, [
            'relations' => ['options'],
        ]);

        return $app->make(ResultResponseContract::class, compact('item'));
    }
}
