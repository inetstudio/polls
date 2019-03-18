<?php

namespace InetStudio\PollsPackage\Analytics\Http\Controllers\Back;

use Illuminate\Http\JsonResponse;
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
     * @param DataTableServiceContract $dataTableService
     *
     * @return JsonResponse
     */
    public function data(DataTableServiceContract $dataTableService): JsonResponse
    {
        return $dataTableService->ajax();
    }
}
