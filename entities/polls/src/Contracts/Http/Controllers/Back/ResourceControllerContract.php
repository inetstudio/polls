<?php

namespace InetStudio\PollsPackage\Polls\Contracts\Http\Controllers\Back;

use Illuminate\Contracts\Foundation\Application;
use InetStudio\PollsPackage\Polls\Contracts\Services\Back\ResourceServiceContract;
use InetStudio\PollsPackage\Polls\Contracts\Services\Back\DataTableServiceContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Requests\Back\SaveItemRequestContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Back\Resource\FormResponseContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Back\Resource\SaveResponseContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Back\Resource\ShowResponseContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Back\Resource\IndexResponseContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Back\Resource\DestroyResponseContract;

/**
 * Interface ResourceControllerContract.
 */
interface ResourceControllerContract
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
                          DataTableServiceContract $dataTableService): IndexResponseContract;

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
                         int $id = 0): ShowResponseContract;

    /**
     * Добавление объекта.
     *
     * @param Application $app
     * @param ResourceServiceContract $resourceService
     *
     * @return FormResponseContract
     */
    public function create(Application $app,
                           ResourceServiceContract $resourceService): FormResponseContract;

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
                          SaveItemRequestContract $request): SaveResponseContract;

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
                         int $id = 0): FormResponseContract;

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
                           int $id = 0): SaveResponseContract;

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
                            int $id = 0): DestroyResponseContract;
}
