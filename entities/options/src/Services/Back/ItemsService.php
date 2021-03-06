<?php

namespace InetStudio\PollsPackage\Options\Services\Back;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use InetStudio\AdminPanel\Base\Services\BaseService;
use InetStudio\PollsPackage\Options\Contracts\Models\PollOptionModelContract;
use InetStudio\PollsPackage\Options\Contracts\Services\Back\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * ItemsService constructor.
     *
     * @param  PollOptionModelContract  $model
     */
    public function __construct(PollOptionModelContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Сохраняем модель.
     *
     * @param  array  $data
     * @param  int  $id
     *
     * @return PollOptionModelContract
     */
    public function save(array $data, int $id): PollOptionModelContract
    {
        $data = Arr::only($data, $this->model->getFillable());

        $item = $this->saveModel($data, $id);

        return $item;
    }

    /**
     * Сохраняем массив моделей.
     *
     * @param  array|Collection  $data
     *
     * @return Collection
     */
    public function saveCollection($data): Collection
    {
        $items = collect();

        foreach ($data as $optionData) {
            $item = $this->save($optionData, is_numeric($optionData['id']) ? (int) $optionData['id'] : 0);

            $items->push($item);
        }

        return $items;
    }
}
