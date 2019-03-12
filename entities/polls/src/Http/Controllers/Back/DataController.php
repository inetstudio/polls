<?php

namespace InetStudio\PollsPackage\Polls\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use InetStudio\PollsPackage\Polls\Contracts\Services\Back\DataTableServiceContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Controllers\Back\DataControllerContract;

/**
 * Class DataController.
 */
class DataController extends Controller implements DataControllerContract
{
    /**
     * Получаем данные для отображения в таблице.
     *
     * @param DataTableServiceContract $dataTableService
     *
     * @return mixed
     */
    public function data(DataTableServiceContract $dataTableService)
    {
        return $dataTableService->ajax();
    }
}
