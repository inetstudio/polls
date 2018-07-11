<?php

namespace InetStudio\Polls\Repositories;

use Illuminate\Database\Eloquent\Builder;
use InetStudio\Polls\Contracts\Models\PollModelContract;
use InetStudio\Polls\Contracts\Repositories\PollsRepositoryContract;
use InetStudio\Polls\Contracts\Http\Requests\Back\Polls\SavePollRequestContract;

/**
 * Class PollsRepository.
 */
class PollsRepository implements PollsRepositoryContract
{
    /**
     * @var PollModelContract
     */
    private $model;

    /**
     * TagsRepository constructor.
     *
     * @param PollModelContract $model
     */
    public function __construct(PollModelContract $model)
    {
        $this->model = $model;
    }

    /**
     * Возвращаем объект по id, либо создаем новый.
     *
     * @param int $id
     *
     * @return PollModelContract
     */
    public function getItemByID(int $id): PollModelContract
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
     * @param SavePollRequestContract $request
     * @param int $id
     *
     * @return PollModelContract
     */
    public function save(SavePollRequestContract $request, int $id): PollModelContract
    {
        $item = $this->getItemByID($id);

        $item->question = strip_tags($request->get('question'));
        $item->single = ($request->filled('single')) ? 1 : 0;
        $item->closed = ($request->filled('closed')) ? 1 : 0;
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
     * Проверяем голосование пользователя.
     *
     * @param int $id
     * @param int $userID
     *
     * @return bool
     */
    public function checkUserVote(int $id, int $userID)
    {
        $item = $this->getItemsQuery([], ['options'])->whereHas('options', function ($optionsQuery) use ($userID) {
                $optionsQuery->whereHas('votes', function ($votesQuery) use ($userID) {
                    $votesQuery->where('user_id', $userID);
                });
            })
            ->where('id', $id)
            ->first();

        return ($item) ? true : false;
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
        $defaultColumns = ['id', 'question'];

        $relations = [
            'options' => function ($query) {
                $query->withCount('votes');
            }
        ];

        return $this->model::select(array_merge($defaultColumns, $extColumns))
            ->with(array_intersect_key($relations, array_flip($with)));
    }
}
