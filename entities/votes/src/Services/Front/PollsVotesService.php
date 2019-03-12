<?php

namespace InetStudio\PollsPackage\Votes\Services\Front;

use Illuminate\Support\Arr;
use InetStudio\AdminPanel\Base\Services\Front\BaseService;
use InetStudio\PollsPackage\Votes\Contracts\Models\PollVoteModelContract;
use InetStudio\PollsPackage\Votes\Contracts\Services\Front\PollsVotesServiceContract;

/**
 * Class PollsVotesService.
 */
class PollsVotesService extends BaseService implements PollsVotesServiceContract
{
    /**
     * PollsVotesService constructor.
     */
    public function __construct()
    {
        parent::__construct(app()->make('InetStudio\PollsPackage\Votes\Contracts\Models\PollVoteModelContract'));
    }

    /**
     * Сохраняем модель.
     *
     * @param array $data
     * @param int $id
     *
     * @return PollVoteModelContract
     */
    public function save(array $data, int $id): PollVoteModelContract
    {
        $item = $this->saveModel(Arr::only($data, $this->model->getFillable()), $id);

        return $item;
    }
}
