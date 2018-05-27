<?php

namespace InetStudio\Polls\Http\Controllers\Back\Polls;

use App\Http\Controllers\Controller;
use InetStudio\Polls\Contracts\Http\Controllers\Back\Polls\PollsDataControllerContract;

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
        $this->services['dataTables'] = app()->make('InetStudio\Polls\Contracts\Services\Back\Polls\PollsDataTableServiceContract');
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
