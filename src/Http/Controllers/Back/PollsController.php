<?php

namespace InetStudio\Polls\Http\Controllers\Back;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use InetStudio\Polls\Models\PollModel;
use Illuminate\Support\Facades\Session;
use InetStudio\Polls\Events\ModifyPollEvent;
use InetStudio\Polls\Models\PollOptionModel;
use InetStudio\Polls\Transformers\PollTransformer;
use InetStudio\Polls\Http\Requests\Back\SavePollRequest;
use InetStudio\AdminPanel\Http\Controllers\Back\Traits\DatatablesTrait;

/**
 * Контроллер для управления опросами.
 *
 * Class PollsController
 */
class PollsController extends Controller
{
    use DatatablesTrait;

    /**
     * Список опросов.
     *
     * @param DataTables $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(DataTables $dataTable)
    {
        $table = $this->generateTable($dataTable, 'polls', 'index');

        return view('admin.module.polls::back.pages.index', compact('table'));
    }

    /**
     * DataTables ServerSide.
     *
     * @return mixed
     * @throws \Exception
     */
    public function data()
    {
        $items = PollModel::query();

        return DataTables::of($items)
            ->setTransformer(new PollTransformer)
            ->rawColumns(['actions'])
            ->make();
    }

    /**
     * Добавление опроса.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.module.polls::back.pages.form', [
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
            return view('admin.module.polls::back.pages.form', [
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
    private function save($request, $id = null): RedirectResponse
    {
        if (! is_null($id) && $id > 0 && $item = PollModel::find($id)) {
            $action = 'отредактирован';
        } else {
            $action = 'создан';
            $item = new PollModel();
        }

        $item->question = strip_tags($request->get('question'));
        $item->single = ($request->filled('single')) ? 1 : 0;
        $item->closed = ($request->filled('closed')) ? 1 : 0;
        $item->save();

        $this->saveOptions($item, $request);

        event(new ModifyPollEvent($item));

        if ($request->ajax()) {
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

    private function saveOptions($item, $request): void
    {
        $item->detachOptionsExcept($request->get('options'));

        if ($request->filled('options')) {
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
    public function destroy($id = null): JsonResponse
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

    public function getInfo(Request $request): JsonResponse
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
    public function getSuggestions(Request $request): JsonResponse
    {
        $search = $request->get('q');
        $data = [];

        $data['items'] = PollModel::select(['id', 'question as name'])->where('question', 'LIKE', '%'.$search.'%')->get()->toArray();

        return response()->json($data);
    }
}
