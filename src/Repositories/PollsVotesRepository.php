<?php

namespace InetStudio\Polls\Repositories;

use Illuminate\Database\Eloquent\Builder;
use InetStudio\Polls\Contracts\Models\PollVoteModelContract;
use InetStudio\Polls\Contracts\Repositories\PollsVotesRepositoryContract;

/**
 * Class PollsVotesRepository.
 */
class PollsVotesRepository implements PollsVotesRepositoryContract
{
    /**
     * @var PollVoteModelContract
     */
    private $model;

    /**
     * TagsRepository constructor.
     *
     * @param PollVoteModelContract $model
     */
    public function __construct(PollVoteModelContract $model)
    {
        $this->model = $model;
    }

    /**
     * Возвращаем объект по id, либо создаем новый.
     *
     * @param int $id
     *
     * @return PollVoteModelContract
     */
    public function getItemByID(int $id): PollVoteModelContract
    {
        return $this->model::find($id) ?? new $this->model;
    }

    /**
     * Возвращаем объекты по списку id.
     *
     * @param $ids
     * @param bool $returnBuilder
     * @param array $fields
     * @param array $relations
     *
     * @return mixed
     */
    public function getItemsByIDs($ids, bool $returnBuilder = false, array $fields = [], array $relations = [])
    {
        $builder = $this->getItemsQuery($fields, $relations)->whereIn('id', (array) $ids);

        if ($returnBuilder) {
            return $builder;
        }

        return $builder->get();
    }

    /**
     * Сохраняем объект.
     *
     * @param array $data
     *
     * @return PollVoteModelContract
     */
    public function save(array $data): PollVoteModelContract
    {
        $item = $this->getItemByID((int) $data['id']);

        $item->user_id = $data['user_id'];
        $item->option_id = $data['option_id'];
        $item->save();

        return $item;
    }

    /**
     * Удаляем объект.
     *
     * @param int $id
     *
     * @return bool
     */
    public function destroy($id): ?bool
    {
        return $this->getItemByID($id)->delete();
    }

    /**
     * Ищем объекты.
     *
     * @param array $conditions
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function searchItems(array $conditions, bool $returnBuilder = false)
    {
        $builder = $this->getItemsQuery([])->where($conditions);

        if ($returnBuilder) {
            return $builder;
        }

        return $builder->get();
    }

    /**
     * Получаем все объекты.
     *
     * @param bool $returnBuilder
     * @param array $fields
     * @param array $relations
     *
     * @return mixed
     */
    public function getAllItems(bool $returnBuilder = false, array $fields = [], array $relations = [])
    {
        $builder = $this->getItemsQuery(array_merge($fields, ['created_at', 'updated_at']), $relations)->orderBy('created_at', 'desc');

        if ($returnBuilder) {
            return $builder;
        }

        return $builder->get();
    }

    /**
     * Возвращаем запрос на получение объектов.
     *
     * @param array $extColumns
     * @param array $with
     *
     * @return Builder
     */
    protected function getItemsQuery($extColumns = [], $with = []): Builder
    {
        $defaultColumns = ['id', 'user_id', 'option_id'];

        $relations = [
            'option',
        ];

        return $this->model::select(array_merge($defaultColumns, $extColumns))
            ->with(array_intersect_key($relations, array_flip($with)));
    }
}
