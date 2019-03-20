<?php

namespace InetStudio\PollsPackage\Analytics\Services\Back;

use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;
use InetStudio\PollsPackage\Analytics\Contracts\Services\Back\DataTableServiceContract;

/**
 * Class DataTableService.
 */
class DataTableService extends DataTable implements DataTableServiceContract
{
    /**
     * Запрос на получение данных таблицы.
     *
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function ajax(): JsonResponse
    {
        $transformer = app()->make('InetStudio\PollsPackage\Analytics\Contracts\Transformers\Back\PollTransformerContract');

        return DataTables::of($this->query())
            ->setTransformer($transformer)
            ->rawColumns(['results'])
            ->make();
    }

    /**
     * Запрос в бд для получения данных для формирования таблицы.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = DB::table('polls')
            ->join('polls_options', 'polls.id', '=', 'polls_options.poll_id')
            ->join('polls_votes', 'polls_options.id', '=', 'polls_votes.option_id')
            ->select('polls.id', 'polls.question', 'orders.price')
            ->select(DB::raw('polls.id, polls.question, count(*) as votes_count'))
            ->groupBy('polls.id');

        return $query;
    }

    /**
     * Билдер для таблицы.
     *
     * @return Builder
     */
    public function html(): Builder
    {
        /** @var Builder $table */
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
            ['data' => 'votes_count', 'name' => 'votes_count', 'title' => 'Количество участников', 'searchable' => false],
            ['data' => 'articles', 'name' => 'articles', 'title' => 'Статьи', 'orderable' => false, 'searchable' => false],
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
