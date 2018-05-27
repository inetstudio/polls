<?php

namespace InetStudio\Polls\Services\Back\Polls;

use League\Fractal\Manager;
use Illuminate\Support\Facades\Session;
use League\Fractal\Serializer\DataArraySerializer;
use InetStudio\Polls\Contracts\Models\PollModelContract;
use InetStudio\Polls\Contracts\Repositories\PollsRepositoryContract;
use InetStudio\Polls\Contracts\Services\Back\Polls\PollsServiceContract;
use InetStudio\Polls\Contracts\Http\Requests\Back\Polls\SavePollRequestContract;

/**
 * Class PollsService.
 */
class PollsService implements PollsServiceContract
{
    /**
     * @var PollsRepositoryContract
     */
    private $repository;

    /**
     * PollsService constructor.
     *
     * @param PollsRepositoryContract $repository
     */
    public function __construct(PollsRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Получаем объект модели.
     *
     * @param int $id
     *
     * @return PollModelContract
     */
    public function getPollObject(int $id = 0)
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
     * @param int $id
     *
     * @return PollModelContract
     */
    public function save(SavePollRequestContract $request, int $id): PollModelContract
    {
        $action = ($id) ? 'отредактирован' : 'создан';
        $item = $this->repository->save($request, $id);

        app()->make('InetStudio\Polls\Contracts\Services\Back\PollsOptions\PollsOptionsServiceContract')
            ->save($request, $item);

        event(app()->makeWith('InetStudio\Polls\Contracts\Events\Back\ModifyPollEventContract', [
            'object' => $item,
        ]));

        Session::flash('success', 'Опрос «'.$item->title.'» успешно '.$action);

        return $item;
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

    /**
     * Получаем подсказки.
     *
     * @param string $search
     * @param $type
     *
     * @return array
     */
    public function getSuggestions(string $search, $type): array
    {
        $items = $this->repository->searchItemsByField('question', $search);

        $resource = (app()->makeWith('InetStudio\Polls\Contracts\Transformers\Back\Polls\SuggestionTransformerContract', [
            'type' => $type,
        ]))->transformCollection($items);

        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());

        $transformation = $manager->createData($resource)->toArray();

        if ($type && $type == 'autocomplete') {
            $data['suggestions'] = $transformation['data'];
        } else {
            $data['items'] = $transformation['data'];
        }

        return $data;
    }
}
