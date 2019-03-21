<?php

namespace InetStudio\PollsPackage\Polls\Http\Controllers\Back;

use Illuminate\Contracts\Foundation\Application;
use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
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
     * Получение объекта.
     *
     * @param Application $app
     * @param ResourceServiceContract $resourceService
     * @param int $id
     *
     * @return ShowResponseContract
     */
    public function show(Application $app,
                         ResourceServiceContract $resourceService,
                         int $id = 0): ShowResponseContract
    {
        $item = $resourceService->getItemById($id);

        return $app->make(ShowResponseContract::class, compact('item'));
    }

    /**
     * Добавление объекта.
     *
     * @param Application $app
     * @param ResourceServiceContract $resourceService
     *
     * @return FormResponseContract
     */
    public function create(Application $app,
                           ResourceServiceContract $resourceService): FormResponseContract
    {
        $item = $resourceService->getItemById();

        return $app->make(FormResponseContract::class, [
            'data' => compact('item'),
        ]);
    }

    /**
     * Создание объекта.
     *
     * @param Application $app
     * @param ResourceServiceContract $resourceService
     * @param SaveItemRequestContract $request
     *
     * @return SaveResponseContract
     */
    public function store(Application $app,
                          ResourceServiceContract $resourceService,
                          SaveItemRequestContract $request): SaveResponseContract
    {
        return $this->save($app, $resourceService, $request);
    }

    /**
     * Редактирование объекта.
     *
     * @param Application $app
     * @param ResourceServiceContract $resourceService
     * @param int $id
     *
     * @return FormResponseContract
     */
    public function edit(Application $app,
                         ResourceServiceContract $resourceService,
                         int $id = 0): FormResponseContract
    {
        $item = $resourceService->getItemById($id);

        return $app->make(FormResponseContract::class, [
            'data' => compact('item'),
        ]);
    }

    /**
     * Обновление объекта.
     *
     * @param Application $app
     * @param ResourceServiceContract $resourceService
     * @param SaveItemRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     */
    public function update(Application $app,
                           ResourceServiceContract $resourceService,
                           SaveItemRequestContract $request,
                           int $id = 0): SaveResponseContract
    {
        return $this->save($app, $resourceService, $request, $id);
    }

    /**
     * Сохранение объекта.
     *
     * @param Application $app
     * @param ResourceServiceContract $resourceService
     * @param SaveItemRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     */
    protected function save(Application $app,
                            ResourceServiceContract $resourceService,
                            SaveItemRequestContract $request,
                            int $id = 0): SaveResponseContract
    {
        $data = $request->all();

        $item = $resourceService->save($data, $id);

        return $app->make(SaveResponseContract::class, compact('item'));
    }

    /**
     * Удаление объекта.
     *
     * @param Application $app
     * @param ResourceServiceContract $resourceService
     * @param int $id
     *
     * @return DestroyResponseContract
     */
    public function destroy(Application $app,
                            ResourceServiceContract $resourceService,
                            int $id = 0): DestroyResponseContract
    {
        $result = $resourceService->destroy($id);

        return $app->make(DestroyResponseContract::class, [
            'result' => ($result === null) ? false : $result,
        ]);
    }
}
