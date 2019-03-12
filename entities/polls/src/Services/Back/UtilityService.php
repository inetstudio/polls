<?php

namespace InetStudio\PollsPackage\Polls\Services\Back;

use Illuminate\Support\Collection;
use InetStudio\AdminPanel\Base\Services\Back\BaseService;
use InetStudio\PollsPackage\Polls\Contracts\Services\Back\UtilityServiceContract;

/**
 * Class UtilityService.
 */
class UtilityService extends BaseService implements UtilityServiceContract
{
    /**
     * UtilityService constructor.
     */
    public function __construct()
    {
        parent::__construct(app()->make('InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract'));
    }

    /**
     * Получаем подсказки.
     *
     * @param string $search
     *
     * @return Collection
     */
    public function getSuggestions(string $search): Collection
    {
        $items = $this->model::where([
            ['question', 'LIKE', '%'.$search.'%']
        ])->get();

        return $items;
    }
}
