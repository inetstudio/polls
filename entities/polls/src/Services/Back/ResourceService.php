<?php

namespace InetStudio\PollsPackage\Polls\Services\Back;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use InetStudio\AdminPanel\Base\Services\Back\BaseService;
use InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract;
use InetStudio\PollsPackage\Polls\Contracts\Services\Back\ResourceServiceContract;

/**
 * Class ResourceService.
 */
class ResourceService extends BaseService implements ResourceServiceContract
{
    /**
     * PollsService constructor.
     */
    public function __construct()
    {
        parent::__construct(app()->make('InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract'));
    }

    /**
     * Сохраняем модель.
     *
     * @param array $data
     * @param int $id
     *
     * @return PollModelContract
     */
    public function save(array $data, int $id): PollModelContract
    {
        $pollsOptionsService = app()->make('InetStudio\PollsPackage\Options\Contracts\Services\Back\ResourceServiceContract');

        $action = ($id) ? 'отредактирован' : 'создан';
        $item = $this->saveModel(Arr::only($data, $this->model->getFillable()), $id);

        $optionsData = collect(Arr::get($data, 'options', []));

        $dataOptionsIds = $optionsData->pluck('id')->toArray();
        $itemsOptionsIds = $item->options()->pluck('id')->toArray();

        $pollsOptionsService->destroy(array_diff($itemsOptionsIds, $dataOptionsIds));
        $optionsData->transform(function ($dataItem) use ($item) {
            $dataItem['poll_id'] = $item['id'];

            return $dataItem;
        });
        $pollsOptionsService->saveCollection($optionsData);

        event(app()->makeWith(
            'InetStudio\PollsPackage\Polls\Contracts\Events\Back\ModifyItemEventContract',
            compact('item')
        ));

        Session::flash('success', 'Опрос «'.$item['question'].'» успешно '.$action);

        return $item;
    }
}