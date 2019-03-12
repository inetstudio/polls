<?php

namespace InetStudio\PollsPackage\Polls\Http\Responses\Back\Resource;

use Illuminate\Contracts\Support\Responsable;
use InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Back\Resource\SaveResponseContract;

/**
 * Class SaveResponse.
 */
class SaveResponse implements SaveResponseContract, Responsable
{
    /**
     * @var PollModelContract
     */
    protected $item;

    /**
     * SaveResponse constructor.
     *
     * @param PollModelContract $item
     */
    public function __construct(PollModelContract $item)
    {
        $this->item = $item;
    }

    /**
     * Возвращаем ответ при сохранении объекта.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function toResponse($request)
    {
        $item = $this->item->fresh();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'id' => $item['id'],
                'title' => $item['question'],
            ], 200);
        } else {
            return response()->redirectToRoute('back.polls.edit', [
                $item['id'],
            ]);
        }
    }
}
