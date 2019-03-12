<?php

namespace InetStudio\PollsPackage\Analytics\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use InetStudio\PollsPackage\Analytics\Contracts\Services\Back\DataTableServiceContract;
use InetStudio\PollsPackage\Analytics\Contracts\Http\Controllers\Back\DataControllerContract;

/**
 * Class DataController.
 */
class DataController extends Controller implements DataControllerContract
{
    /**
     * Получаем данные для отображения в таблице.
     *
     * @return mixed
     */
    public function data(DataTableServiceContract $dataTableService)
    {
        return $dataTableService->ajax();
    }
}
