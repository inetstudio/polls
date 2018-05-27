<?php

namespace InetStudio\Polls\Http\Responses\Back\Polls;

use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Polls\Contracts\Models\PollModelContract;
use InetStudio\Polls\Contracts\Http\Responses\Back\Polls\SaveResponseContract;

/**
 * Class SaveResponse.
 */
class SaveResponse implements SaveResponseContract, Responsable
{
    /**
     * @var PollModelContract
     */
    private $item;

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
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'id' => $this->item->id,
                'title' => $this->item->question,
            ], 200);
        } else {
            return response()->redirectToRoute('back.polls.edit', [
                $this->item->fresh()->id,
            ]);
        }
    }
}
