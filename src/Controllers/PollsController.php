<?php

namespace InetStudio\Polls\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use InetStudio\Polls\Models\PollModel;
use InetStudio\Polls\Models\PollOptionModel;
use InetStudio\Polls\Requests\SavePollRequest;
use InetStudio\Polls\Transformers\PollTransformer;

/**
 * Контроллер для управления опросами.
 *
 * Class PollsController
 */
class PollsController extends Controller
{
    /**
     * Список опросов.
     *
     * @param Datatables $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Datatables $dataTable)
    {
        $table = $dataTable->getHtmlBuilder();

        $table->columns($this->getColumns());
        $table->ajax($this->getAjaxOptions());
        $table->parameters($this->getTableParameters());

        return view('admin.module.polls::pages.index', compact('table'));
    }

    /**
     * Свойства колонок datatables.
     *
     * @return array
     */
    private function getColumns()
    {
        return [
            ['data' => 'question', 'name' => 'question', 'title' => 'Вопрос'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Дата создания'],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Дата обновления'],
            ['data' => 'actions', 'name' => 'actions', 'title' => 'Действия', 'orderable' => false, 'searchable' => false],
        ];
    }

    /**
     * Свойства ajax datatables.
     *
     * @return array
     */
    private function getAjaxOptions()
    {
        return [
            'url' => route('back.polls.data'),
            'type' => 'POST',
            'data' => 'function(data) { data._token = $(\'meta[name="csrf-token"]\').attr(\'content\'); }',
        ];
    }

    /**
     * Свойства datatables.
     *
     * @return array
     */
    private function getTableParameters()
    {
        return [
            'paging' => true,
            'pagingType' => 'full_numbers',
            'searching' => true,
            'info' => false,
            'searchDelay' => 350,
            'language' => [
                'url' => asset('admin/js/plugins/datatables/locales/russian.json'),
            ],
        ];
    }

    /**
     * Datatables serverside.
     *
     * @return mixed
     */
    public function data()
    {
        $items = PollModel::query();

        return Datatables::of($items)
            ->setTransformer(new PollTransformer)
            ->escapeColumns(['actions'])
            ->make();
    }

    /**
     * Добавление опроса.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.module.polls::pages.form', [
            'item' => new PollModel(),
        ]);
    }

    /**
     * Создание опроса.
     *
     * @param SavePollRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SavePollRequest $request)
    {
        return $this->save($request);
    }

    /**
     * Редактирование опроса.
     *
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id = null)
    {
        if (! is_null($id) && $id > 0 && $item = PollModel::find($id)) {
            return view('admin.module.polls::pages.form', [
                'item' => $item,
            ]);
        } else {
            abort(404);
        }
    }

    /**
     * Обновление опроса.
     *
     * @param SavePollRequest $request
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SavePollRequest $request, $id = null)
    {
        return $this->save($request, $id);
    }

    /**
     * Сохранение опроса.
     *
     * @param SavePollRequest $request
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     */
    private function save($request, $id = null)
    {
        if (! is_null($id) && $id > 0 && $item = PollModel::find($id)) {
            $action = 'отредактирован';
        } else {
            $action = 'создан';
            $item = new PollModel();
        }

        $item->question = strip_tags($request->get('question'));
        $item->single = ($request->has('single')) ? 1 : 0;
        $item->closed = ($request->has('closed')) ? 1 : 0;
        $item->save();

        $this->saveOptions($item, $request);

        if($request->ajax()) {
            return response()->json([
                'success' => true,
                'id' => $item->id,
                'title' => $item->question,
            ], 200);
        } else {
            Session::flash('success', 'Опрос «'.$item->question.'» успешно '.$action);

            return redirect()->to(route('back.polls.edit', $item->fresh()->id));
        }
    }

    private function saveOptions($item, $request)
    {
        $item->detachOptionsExcept($request->get('options'));

        if ($request->has('options')) {
            foreach ($request->get('options') as $option) {
                if ($option['id']) {
                    PollOptionModel::where('id', $option['id'])->update($option['properties']);
                } else {
                    $option['properties']['id'] = $option['id'];
                    $item->attachOption($option['properties']);
                }
            }
        }
    }

    /**
     * Удаление опроса.
     *
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id = null)
    {
        if (! is_null($id) && $id > 0 && $item = PollModel::find($id)) {
            $item->delete();

            return response()->json([
                'success' => true,
            ]);
        } else {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    public function getInfo(Request $request)
    {
        $id = $request->get('id');

        if (! is_null($id) && $id > 0 && $item = PollModel::find($id)) {
            return response()->json([
                'id' => $item->id,
                'question' => $item->question,
                'options' => $item->options->map(function ($option) {
                    return [
                        'id' => $option->id,
                        'properties' => [
                            'answer' => $option->answer,
                        ],
                    ];
                })->toArray(),
                'success' => true,
            ]);
        } else {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    /**
     * Возвращаем опросы для поля.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSuggestions(Request $request)
    {
        $search = $request->get('q');
        $data = [];

        $data['items'] = PollModel::select(['id', 'question as name'])->where('question', 'LIKE', '%'.$search.'%')->get()->toArray();

        return response()->json($data);
    }
}
