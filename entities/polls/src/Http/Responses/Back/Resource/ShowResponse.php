<?php

namespace InetStudio\PollsPackage\Polls\Http\Responses\Back\Resource;

use League\Fractal\Manager;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;
use League\Fractal\Resource\Item as FractalItem;
use InetStudio\AdminPanel\Serializers\SimpleDataArraySerializer;
use InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Back\Resource\ShowResponseContract;

/**
 * Class ShowResponse.
 */
class ShowResponse implements ShowResponseContract, Responsable
{
    /**
     * @var PollModelContract
     */
    protected $item;

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
        $resource = new FractalItem(
            $this->item,
            app()->make('InetStudio\PollsPackage\Polls\Contracts\Transformers\Back\Resource\ShowTransformerContract')
        );

        $manager = new Manager();
        $manager->setSerializer(new SimpleDataArraySerializer());

        $transformation = $manager->createData($resource)->toArray();
        $transformation['success'] = ((bool) $transformation['id']);

        return response()->json($transformation);
    }
}
