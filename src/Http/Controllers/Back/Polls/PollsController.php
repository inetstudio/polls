<?php

namespace InetStudio\Polls\Http\Controllers\Back\Polls;

use App\Http\Controllers\Controller;
use InetStudio\Polls\Contracts\Http\Responses\Back\Polls\FormResponseContract;
use InetStudio\Polls\Contracts\Http\Responses\Back\Polls\SaveResponseContract;
use InetStudio\Polls\Contracts\Http\Responses\Back\Polls\ShowResponseContract;
use InetStudio\Polls\Contracts\Http\Responses\Back\Polls\IndexResponseContract;
use InetStudio\Polls\Contracts\Http\Requests\Back\Polls\SavePollRequestContract;
use InetStudio\Polls\Contracts\Http\Responses\Back\Polls\DestroyResponseContract;
use InetStudio\Polls\Contracts\Http\Controllers\Back\Polls\PollsControllerContract;

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
        $this->services['dataTables'] = app()->make('InetStudio\Polls\Contracts\Services\Back\Polls\PollsDataTableServiceContract');
    }

    /**
     * Список объектов.
     *
     * @return IndexResponseContract
     */
    public function index(): IndexResponseContract
    {
        $table = $this->services['dataTables']->html();

        return app()->makeWith('InetStudio\Polls\Contracts\Http\Responses\Back\Polls\IndexResponseContract', [
            'data' => compact('table'),
        ]);
    }

    /**
     * Получение объекта.
     *
     * @param int $id
     *
     * @return ShowResponseContract
     */
    public function show(int $id = 0): ShowResponseContract
    {
        $item = $this->services['polls']->getPollObject($id);

        return app()->makeWith('InetStudio\Polls\Contracts\Http\Responses\Back\Polls\ShowResponseContract', [
            'item' => $item,
        ]);
    }

    /**
     * Добавление объекта.
     *
     * @return FormResponseContract
     */
    public function create(): FormResponseContract
    {
        $item = $this->services['polls']->getPollObject();

        return app()->makeWith('InetStudio\Polls\Contracts\Http\Responses\Back\Polls\FormResponseContract', [
            'data' => compact('item'),
        ]);
    }

    /**
     * Создание объекта.
     *
     * @param SavePollRequestContract $request
     *
     * @return SaveResponseContract
     */
    public function store(SavePollRequestContract $request): SaveResponseContract
    {
        return $this->save($request);
    }

    /**
     * Редактирование объекта.
     *
     * @param int $id
     *
     * @return FormResponseContract
     */
    public function edit(int $id = 0): FormResponseContract
    {
        $item = $this->services['polls']->getPollObject($id);

        return app()->makeWith('InetStudio\Polls\Contracts\Http\Responses\Back\Polls\FormResponseContract', [
            'data' => compact('item'),
        ]);
    }

    /**
     * Обновление объекта.
     *
     * @param SavePollRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     */
    public function update(SavePollRequestContract $request, int $id = 0): SaveResponseContract
    {
        return $this->save($request, $id);
    }

    /**
     * Сохранение объекта.
     *
     * @param SavePollRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     */
    private function save(SavePollRequestContract $request, int $id = 0): SaveResponseContract
    {
        $item = $this->services['polls']->save($request, $id);

        return app()->makeWith('InetStudio\Polls\Contracts\Http\Responses\Back\Polls\SaveResponseContract', [
            'item' => $item,
        ]);
    }

    /**
     * Удаление объекта.
     *
     * @param int $id
     *
     * @return DestroyResponseContract
     */
    public function destroy(int $id = 0): DestroyResponseContract
    {
        $result = $this->services['polls']->destroy($id);

        return app()->makeWith('InetStudio\Polls\Contracts\Http\Responses\Back\Polls\DestroyResponseContract', [
            'result' => ($result === null) ? false : $result,
        ]);
    }
}
