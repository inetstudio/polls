<?php

namespace InetStudio\PollsPackage\Polls\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use InetStudio\PollsPackage\Polls\Contracts\Services\Back\ResourceServiceContract;
use InetStudio\PollsPackage\Polls\Contracts\Services\Back\DataTableServiceContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Requests\Back\SaveItemRequestContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Controllers\Back\ResourceControllerContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Back\Resource\FormResponseContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Back\Resource\SaveResponseContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Back\Resource\ShowResponseContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Back\Resource\IndexResponseContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Back\Resource\DestroyResponseContract;

/**
 * Class ResourceController.
 */
class ResourceController extends Controller implements ResourceControllerContract
{
    /**
     * Список объектов.
     *
     * @param DataTableServiceContract $dataTableService
     *
     * @return IndexResponseContract
     */
    public function index(DataTableServiceContract $dataTableService): IndexResponseContract
    {
        $table = $dataTableService->html();

        return app()->makeWith(IndexResponseContract::class, [
            'data' => compact('table'),
        ]);
    }

    /**
     * Получение объекта.
     *
     * @param ResourceServiceContract $resourceService
     * @param int $id
     *
     * @return ShowResponseContract
     */
    public function show(ResourceServiceContract $resourceService, int $id = 0): ShowResponseContract
    {
        $item = $resourceService->getItemById($id);

        return app()->makeWith(ShowResponseContract::class, [
            'item' => $item,
        ]);
    }

    /**
     * Добавление объекта.
     *
     * @param ResourceServiceContract $resourceService
     *
     * @return FormResponseContract
     */
    public function create(ResourceServiceContract $resourceService): FormResponseContract
    {
        $item = $resourceService->getItemById();

        return app()->makeWith(FormResponseContract::class, [
            'data' => compact('item'),
        ]);
    }

    /**
     * Создание объекта.
     *
     * @param ResourceServiceContract $resourceService
     * @param SaveItemRequestContract $request
     *
     * @return SaveResponseContract
     */
    public function store(ResourceServiceContract $resourceService, SaveItemRequestContract $request): SaveResponseContract
    {
        return $this->save($resourceService, $request);
    }

    /**
     * Редактирование объекта.
     *
     * @param ResourceServiceContract $resourceService
     * @param int $id
     *
     * @return FormResponseContract
     */
    public function edit(ResourceServiceContract $resourceService, int $id = 0): FormResponseContract
    {
        $item = $resourceService->getItemById($id);

        return app()->makeWith(FormResponseContract::class, [
            'data' => compact('item'),
        ]);
    }

    /**
     * Обновление объекта.
     *
     * @param ResourceServiceContract $resourceService
     * @param SaveItemRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     */
    public function update(ResourceServiceContract $resourceService, SaveItemRequestContract $request, int $id = 0): SaveResponseContract
    {
        return $this->save($resourceService, $request, $id);
    }

    /**
     * Сохранение объекта.
     *
     * @param ResourceServiceContract $resourceService
     * @param SaveItemRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     */
    protected function save(ResourceServiceContract $resourceService, SaveItemRequestContract $request, int $id = 0): SaveResponseContract
    {
        $data = $request->all();

        $item = $resourceService->save($data, $id);

        return app()->makeWith(SaveResponseContract::class, [
            'item' => $item,
        ]);
    }

    /**
     * Удаление объекта.
     *
     * @param ResourceServiceContract $resourceService
     * @param int $id
     *
     * @return DestroyResponseContract
     */
    public function destroy(ResourceServiceContract $resourceService, int $id = 0): DestroyResponseContract
    {
        $result = $resourceService->destroy($id);

        return app()->makeWith(DestroyResponseContract::class, [
            'result' => ($result === null) ? false : $result,
        ]);
    }
}
