<?php

namespace InetStudio\Polls\Http\Controllers\Back\Analytics;

use App\Http\Controllers\Controller;
use InetStudio\Polls\Contracts\Http\Controllers\Back\Analytics\PollsDataControllerContract;

/**
 * Class PollsDataController.
 */
class PollsDataController extends Controller implements PollsDataControllerContract
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    private $services;

    /**
     * PollsDataController constructor.
     */
    public function __construct()
    {
        $this->services['dataTables'] = app()->make('InetStudio\Polls\Contracts\Services\Back\Analytics\PollsDataTableServiceContract');
    }

    /**
     * Получаем данные для отображения в таблице.
     *
     * @return mixed
     */
    public function data()
    {
        return $this->services['dataTables']->ajax();
    }
}
