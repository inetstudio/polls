<?php

namespace InetStudio\PollsPackage\Analytics\Http\Responses\Back;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract;
use InetStudio\PollsPackage\Analytics\Contracts\Http\Responses\Back\ResultResponseContract;

/**
 * Class ResultsResponse.
 */
class ResultResponse implements ResultResponseContract, Responsable
{
    /**
     * @var PollModelContract
     */
    protected $item;

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
        $transformer = app()->make('InetStudio\PollsPackage\Analytics\Contracts\Transformers\Back\Result\PollTransformerContract');
        $serializer = app()->make('InetStudio\AdminPanel\Contracts\Serializers\SimpleDataArraySerializerContract');

        $resource = new Item($this->item, $transformer);


        $manager = new Manager();
        $manager->setSerializer($serializer);

        $item = $manager->createData($resource)->toArray();

        return view('admin.module.polls.analytics::back.modals.result', compact('item'))->render();
    }
}
