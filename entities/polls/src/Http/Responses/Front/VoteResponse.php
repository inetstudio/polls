<?php

namespace InetStudio\PollsPackage\Polls\Http\Responses\Front;

use Illuminate\Http\Request;
use InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Front\VoteResponseContract;

/**
 * Class VoteResponse.
 */
class VoteResponse implements VoteResponseContract
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
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return response()->json(
            [
                'success' => ($this->item) ? true : false,
            ]
        );
    }
}
