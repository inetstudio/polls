<?php

namespace InetStudio\PollsPackage\Votes\Services\Front;

use Illuminate\Support\Arr;
use InetStudio\AdminPanel\Base\Services\BaseService;
use InetStudio\PollsPackage\Votes\Contracts\Models\PollVoteModelContract;
use InetStudio\PollsPackage\Votes\Contracts\Services\Front\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * ItemsService constructor.
     *
     * @param  PollVoteModelContract  $model
     */
    public function __construct(PollVoteModelContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Сохраняем модель.
     *
     * @param  array  $data
     * @param  int  $id
     *
     * @return PollVoteModelContract
     */
    public function save(array $data, int $id): PollVoteModelContract
    {
        $data = Arr::only($data, $this->model->getFillable());

        $item = $this->saveModel($data, $id);

        return $item;
    }
}
