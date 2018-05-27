<?php

namespace InetStudio\Polls\Http\Controllers\Back\Analytics;

use App\Http\Controllers\Controller;
use InetStudio\Polls\Contracts\Http\Responses\Back\Analytics\IndexResponseContract;
use InetStudio\Polls\Contracts\Http\Responses\Back\Analytics\ResultResponseContract;
use InetStudio\Polls\Contracts\Http\Controllers\Back\Analytics\PollsControllerContract;

/**
 * Class PollsController.
 */
class PollsController extends Controller implements PollsControllerContract
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    protected $services;

    /**
     * PollsController constructor.
     */
    public function __construct()
    {
        $this->services['polls'] = app()->make('InetStudio\Polls\Contracts\Services\Back\Polls\PollsServiceContract');
        $this->services['dataTables'] = app()->make('InetStudio\Polls\Contracts\Services\Back\Analytics\PollsDataTableServiceContract');
    }

    /**
     * Список объектов.
     *
     * @return IndexResponseContract
     */
    public function index(): IndexResponseContract
    {
        $table = $this->services['dataTables']->html();

        return app()->makeWith('InetStudio\Polls\Contracts\Http\Responses\Back\Analytics\IndexResponseContract', [
            'data' => compact('table'),
        ]);
    }

    /**
     * Результаты опроса.
     *
     * @param null $id
     *
     * @return ResultResponseContract
     *
     * @throws \Throwable
     */
    public function getPollResult($id = null): ResultResponseContract
    {
        $item = $this->services['polls']->getPollsByIDs($id, false, [], ['options'])->first();

        return app()->makeWith('InetStudio\Polls\Contracts\Http\Responses\Back\Analytics\ResultResponseContract', [
            'item' => $item,
        ]);
    }
}
