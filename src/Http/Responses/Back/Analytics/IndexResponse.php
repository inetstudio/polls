<?php

namespace InetStudio\Polls\Http\Responses\Back\Analytics;

use Illuminate\View\View;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Polls\Contracts\Http\Responses\Back\Analytics\IndexResponseContract;

/**
 * Class IndexResponse.
 */
class IndexResponse implements IndexResponseContract, Responsable
{
    /**
     * @var array
     */
    private $data;

    /**
     * IndexResponse constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Возвращаем ответ при открытии списка объектов.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return View
     */
    public function toResponse($request): View
    {
        return view('admin.module.polls::back.pages.analytics', $this->data);
    }
}
