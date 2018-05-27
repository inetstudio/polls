<?php

namespace InetStudio\Polls\Repositories;

use Illuminate\Database\Eloquent\Builder;
use InetStudio\Polls\Contracts\Models\PollModelContract;
use InetStudio\Polls\Contracts\Models\PollOptionModelContract;
use InetStudio\Polls\Contracts\Repositories\PollsOptionsRepositoryContract;
use InetStudio\Polls\Contracts\Http\Requests\Back\Polls\SavePollRequestContract;

/**
 * Class PollsOptionsRepository.
 */
class PollsOptionsRepository implements PollsOptionsRepositoryContract
{
    /**
     * @var PollOptionModelContract
     */
    private $model;

    /**
     * TagsRepository constructor.
     *
     * @param PollOptionModelContract $model
     */
    public function __construct(PollOptionModelContract $model)
    {
        $this->model = $model;
    }

    /**
     * Возвращаем объект по id, либо создаем новый.
     *
     * @param int $id
     *
     * @return PollOptionModelContract
     */
    public function getItemByID(int $id): PollOptionModelContract
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
     * @param PollModelContract $poll
     *
     * @return PollOptionModelContract
     */
    public function save(array $data, PollModelContract $poll): PollOptionModelContract
    {
        $item = $this->getItemByID((int) $data['id']);

        $item->answer = strip_tags($data['properties']['answer']);
        $item->poll_id = $poll->id;
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
     * @param string $field
     * @param $value
     * @param bool $returnBuilder
     * @param array $fields
     * @param array $relations
     *
     * @return mixed
     */
    public function searchItemsByField(string $field, string $value, bool $returnBuilder = false, array $fields = [], array $relations = [])
    {
        $builder = $this->getItemsQuery($fields, $relations)->where($field, 'LIKE', '%'.$value.'%');

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
        $defaultColumns = ['id', 'answer', 'poll_id'];

        $relations = [
            'poll',
        ];

        return $this->model::select(array_merge($defaultColumns, $extColumns))
            ->with(array_intersect_key($relations, array_flip($with)));
    }
}
