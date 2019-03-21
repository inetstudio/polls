<?php

namespace InetStudio\PollsPackage\Polls\Services\Back;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use InetStudio\AdminPanel\Base\Services\BaseService;
use InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract;
use InetStudio\PollsPackage\Polls\Contracts\Services\Back\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * ItemsService constructor.
     *
     * @param PollModelContract $model
     */
    public function __construct(PollModelContract $model)
    {
        parent::__construct($model);
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
        $pollsOptionsService = app()->make('InetStudio\PollsPackage\Options\Contracts\Services\Back\ItemsServiceContract');

        $action = ($id) ? 'отредактирован' : 'создан';

        $data = Arr::only($data, $this->model->getFillable());
        $item = $this->saveModel($data, $id);

        $optionsData = collect(Arr::get($data, 'options', []));

        $dataOptionsIds = $optionsData->pluck('id')->toArray();
        $itemOptionsIds = $item->options()->pluck('id')->toArray();

        $pollsOptionsService->destroy(array_diff($itemOptionsIds, $dataOptionsIds));
        $optionsData->transform(function ($dataItem) use ($item) {
            $dataItem['poll_id'] = $item['id'];

            return $dataItem;
        });
        $pollsOptionsService->saveCollection($optionsData);

        event(app()->make(
            'InetStudio\PollsPackage\Polls\Contracts\Events\Back\ModifyItemEventContract',
            compact('item')
        ));

        Session::flash('success', 'Опрос «'.$item['question'].'» успешно '.$action);

        return $item;
    }
}
