<?php

namespace InetStudio\Polls\Services\Back\PollsOptions;

use Illuminate\Support\Collection;
use InetStudio\Polls\Contracts\Models\PollModelContract;
use InetStudio\Polls\Contracts\Models\PollOptionModelContract;
use InetStudio\Polls\Contracts\Repositories\PollsOptionsRepositoryContract;
use InetStudio\Polls\Contracts\Http\Requests\Back\Polls\SavePollRequestContract;
use InetStudio\Polls\Contracts\Services\Back\PollsOptions\PollsOptionsServiceContract;

/**
 * Class PollsOptionsService.
 */
class PollsOptionsService implements PollsOptionsServiceContract
{
    /**
     * @var PollsOptionsRepositoryContract
     */
    private $repository;

    /**
     * PollsOptionsService constructor.
     *
     * @param PollsOptionsRepositoryContract $repository
     */
    public function __construct(PollsOptionsRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Получаем объект модели.
     *
     * @param int $id
     *
     * @return PollOptionModelContract
     */
    public function getPollOptionObject(int $id = 0)
    {
        return $this->repository->getItemByID($id);
    }

    /**
     * Получаем объекты по списку id.
     *
     * @param array|int $ids
     * @param bool $returnBuilder
     * @param array $fields
     * @param array $relations
     *
     * @return mixed
     */
    public function getPollsByIDs($ids, bool $returnBuilder = false, array $fields = [], array $relations = [])
    {
        return $this->repository->getItemsByIDs($ids, $returnBuilder, $fields, $relations);
    }

    /**
     * Сохраняем модель.
     *
     * @param SavePollRequestContract $request
     * @param PollModelContract $poll
     *
     * @return Collection
     */
    public function save(SavePollRequestContract $request, PollModelContract $poll): Collection
    {
        if ($request->filled('options')) {
            $ids = collect($request->get('options'))->pluck('id');
            $poll->options->whereNotIn('id', [])->each(function (PollOptionModelContract $option) {
                $this->repository->destroy($option->getAttribute('id'));
            });

            foreach ($request->get('options') as $option) {
                $this->repository->save($option, $poll);
            }
        }

        return $poll->options;
    }

    /**
     * Удаляем модель.
     *
     * @param $id
     *
     * @return bool
     */
    public function destroy(int $id): ?bool
    {
        return $this->repository->destroy($id);
    }
}
