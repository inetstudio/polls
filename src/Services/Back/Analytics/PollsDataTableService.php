<?php

namespace InetStudio\Polls\Services\Back\Analytics;

use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;
use InetStudio\Polls\Contracts\Repositories\PollsRepositoryContract;
use InetStudio\Polls\Contracts\Services\Back\Analytics\PollsDataTableServiceContract;

/**
 * Class PollsDataTableService.
 */
class PollsDataTableService extends DataTable implements PollsDataTableServiceContract
{
    /**
     * @var PollsRepositoryContract
     */
    private $repository;

    /**
     * PollsDataTableService constructor.
     *
     * @param PollsRepositoryContract $repository
     */
    public function __construct(PollsRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Запрос на получение данных таблицы.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     */
    public function ajax()
    {
        $transformer = app()->make('InetStudio\Polls\Contracts\Transformers\Back\Analytics\PollTransformerContract');

        return DataTables::of($this->query())
            ->setTransformer($transformer)
            ->rawColumns(['results'])
            ->make();
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = $this->repository->getAllItems(true, [], ['options']);

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): Builder
    {
        $table = app('datatables.html');

        return $table
            ->columns($this->getColumns())
            ->ajax($this->getAjaxOptions())
            ->parameters($this->getParameters());
    }

    /**
     * Получаем колонки.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            ['data' => 'question', 'name' => 'question', 'title' => 'Вопрос'],
            ['data' => 'voters', 'name' => 'voters', 'title' => 'Количество участников'],
            ['data' => 'results', 'name' => 'results', 'title' => 'Результаты', 'orderable' => false, 'searchable' => false],
        ];
    }

    /**
     * Свойства ajax datatables.
     *
     * @return array
     */
    protected function getAjaxOptions(): array
    {
        return [
            'url' => route('back.polls.analytics.data.index'),
            'type' => 'POST',
        ];
    }

    /**
     * Свойства datatables.
     *
     * @return array
     */
    protected function getParameters(): array
    {
        $i18n = trans('admin::datatables');

        return [
            'paging' => true,
            'pagingType' => 'full_numbers',
            'searching' => true,
            'info' => false,
            'searchDelay' => 350,
            'language' => $i18n,
        ];
    }
}
