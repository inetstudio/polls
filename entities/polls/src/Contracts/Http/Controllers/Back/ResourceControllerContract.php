<?php

namespace InetStudio\PollsPackage\Polls\Contracts\Http\Controllers\Back;

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
     * @param DataTableServiceContract $dataTableService
     *
     * @return IndexResponseContract
     */
    public function index(DataTableServiceContract $dataTableService): IndexResponseContract;

    /**
     * Получение объекта.
     *
     * @param ResourceServiceContract $resourceService
     * @param int $id
     *
     * @return ShowResponseContract
     */
    public function show(ResourceServiceContract $resourceService, int $id = 0): ShowResponseContract;

    /**
     * Добавление объекта.
     *
     * @param ResourceServiceContract $resourceService
     *
     * @return FormResponseContract
     */
    public function create(ResourceServiceContract $resourceService): FormResponseContract;

    /**
     * Создание объекта.
     *
     * @param ResourceServiceContract $resourceService
     * @param SaveItemRequestContract $request
     *
     * @return SaveResponseContract
     */
    public function store(ResourceServiceContract $resourceService, SaveItemRequestContract $request): SaveResponseContract;

    /**
     * Редактирование объекта.
     *
     * @param ResourceServiceContract $resourceService
     * @param int $id
     *
     * @return FormResponseContract
     */
    public function edit(ResourceServiceContract $resourceService, int $id = 0): FormResponseContract;

    /**
     * Обновление объекта.
     *
     * @param ResourceServiceContract $resourceService
     * @param SaveItemRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     */
    public function update(ResourceServiceContract $resourceService, SaveItemRequestContract $request, int $id = 0): SaveResponseContract;

    /**
     * Удаление объекта.
     *
     * @param ResourceServiceContract $resourceService
     * @param int $id
     *
     * @return DestroyResponseContract
     */
    public function destroy(ResourceServiceContract $resourceService, int $id = 0): DestroyResponseContract;
}
