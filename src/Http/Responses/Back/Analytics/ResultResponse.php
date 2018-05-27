<?php

namespace InetStudio\Polls\Http\Responses\Back\Analytics;

use Illuminate\Contracts\Support\Responsable;
use InetStudio\Polls\Contracts\Models\PollModelContract;
use InetStudio\Polls\Contracts\Http\Responses\Back\Analytics\ResultResponseContract;

/**
 * Class ResultsResponse.
 */
class ResultResponse implements ResultResponseContract, Responsable
{
    /**
     * @var PollModelContract
     */
    private $item;

    /**
     * ResultResponse constructor.
     *
     * @param PollModelContract $item
     */
    public function __construct(PollModelContract $item)
    {
        $this->item = $item;
    }

    /**
     * Возвращаем результаты опроса.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return string
     *
     * @throws \Throwable
     */
    public function toResponse($request): string
    {
        return view('admin.module.polls::back.pages.modals.result', [
            'item' => $this->item
        ])->render();
    }
}
