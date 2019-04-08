<?php

namespace InetStudio\PollsPackage\Analytics\Http\Controllers\Back;

use Throwable;
use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use Illuminate\Contracts\Container\BindingResolutionException;
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
     * @param  DataTableServiceContract  $dataTableService
     *
     * @return IndexResponseContract
     *
     * @throws BindingResolutionException
     */
    public function index(DataTableServiceContract $dataTableService): IndexResponseContract
    {
        $table = $dataTableService->html();

        return $this->app->make(
            IndexResponseContract::class,
            [
                'data' => compact('table'),
            ]
        );
    }

    /**
     * Результаты опроса.
     *
     * @param  AnalyticsServiceContract  $analyticsService
     * @param  int  $id
     *
     * @return ResultResponseContract
     *
     * @throws Throwable
     */
    public function getPollResult(
        AnalyticsServiceContract $analyticsService,
        int $id = 0
    ): ResultResponseContract {
        $item = $analyticsService->getItemById(
            $id,
            [
                'relations' => ['options'],
            ]
        );

        return $this->app->make(ResultResponseContract::class, compact('item'));
    }
}
