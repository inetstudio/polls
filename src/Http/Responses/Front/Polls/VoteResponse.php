<?php

namespace InetStudio\Polls\Http\Responses\Front\Polls;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Polls\Contracts\Models\PollModelContract;
use InetStudio\Polls\Contracts\Http\Responses\Front\Polls\VoteResponseContract;

/**
 * Class VoteResponse.
 */
class VoteResponse implements VoteResponseContract, Responsable
{
    /**
     * @var PollModelContract
     */
    private $item;

    /**
     * VoteResponse constructor.
     *
     * @param $item
     */
    public function __construct($item)
    {
        $this->item = $item;
    }

    /**
     * Возвращаем ответ при голосовании.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        return response()->json([
            'success' => ($this->item) ? true : false,
        ]);
    }
}
