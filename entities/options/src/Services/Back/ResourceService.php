<?php

namespace InetStudio\PollsPackage\Options\Services\Back;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use InetStudio\AdminPanel\Base\Services\Back\BaseService;
use InetStudio\PollsPackage\Options\Contracts\Models\PollOptionModelContract;
use InetStudio\PollsPackage\Options\Contracts\Services\Back\ResourceServiceContract;

/**
 * Class ResourceService.
 */
class ResourceService extends BaseService implements ResourceServiceContract
{
    /**
     * ResourceService constructor.
     */
    public function __construct()
    {
        parent::__construct(app()->make('InetStudio\PollsPackage\Options\Contracts\Models\PollOptionModelContract'));
    }

    /**
     * Сохраняем модель.
     *
     * @param array $data
     * @param int $id
     *
     * @return PollOptionModelContract
     */
    public function save(array $data, int $id): PollOptionModelContract
    {
        $item = $this->saveModel(Arr::only($data, $this->model->getFillable()), $id);

        return $item;
    }

    /**
     * Сохраняем массив моделей.
     *
     * @param array|Collection $data
     *
     * @return Collection
     */
    public function saveCollection($data): Collection
    {
        $items = collect();

        foreach ($data as $optionData) {
            $item = $this->save($optionData, (int) ($optionData['id'] ?? 0));

            $items->push($item);
        }

        return $items;
    }
}
