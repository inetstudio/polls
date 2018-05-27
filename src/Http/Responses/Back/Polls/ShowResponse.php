<?php

namespace InetStudio\Polls\Http\Responses\Back\Polls;

use League\Fractal\Manager;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;
use League\Fractal\Resource\Item as FractalItem;
use InetStudio\Polls\Contracts\Models\PollModelContract;
use InetStudio\AdminPanel\Serializers\SimpleDataArraySerializer;
use InetStudio\Polls\Contracts\Http\Responses\Back\Polls\ShowResponseContract;

/**
 * Class ShowResponse.
 */
class ShowResponse implements ShowResponseContract, Responsable
{
    /**
     * @var PollModelContract
     */
    private $item;

    /**
     * ShowResponse constructor.
     *
     * @param PollModelContract $item
     */
    public function __construct(PollModelContract $item)
    {
        $this->item = $item;
    }

    /**
     * Возвращаем ответ при получении объекта.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        $resource = new FractalItem($this->item, app()->make('InetStudio\Polls\Contracts\Transformers\Back\Polls\ShowPollTransformerContract'));

        $manager = new Manager();
        $manager->setSerializer(new SimpleDataArraySerializer());

        $transformation = $manager->createData($resource)->toArray();
        $transformation['success'] = (!! $transformation['id']);

        return response()->json($transformation);
    }
}
