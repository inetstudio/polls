<?php

namespace InetStudio\PollsPackage\Polls\Http\Responses\Front;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Front\VoteResponseContract;

/**
 * Class VoteResponse.
 */
class VoteResponse implements VoteResponseContract, Responsable
{
    /**
     * @var PollModelContract
     */
    protected $item;

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
