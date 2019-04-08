<?php

namespace InetStudio\PollsPackage\Polls\Http\Responses\Back\Resource;

use League\Fractal\Manager;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Responsable;
use League\Fractal\Resource\Item as FractalItem;
use Illuminate\Contracts\Container\BindingResolutionException;
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
     * @param  PollModelContract  $item
     */
    public function __construct(PollModelContract $item)
    {
        $this->item = $item;
    }

    /**
     * Возвращаем ответ при получении объекта.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     *
     * @throws BindingResolutionException
     */
    public function toResponse($request)
    {
        $resource = new FractalItem(
            $this->item,
            app()->make('InetStudio\PollsPackage\Polls\Contracts\Transformers\Back\Resource\ShowTransformerContract')
        );

        $serializer = app()->make('InetStudio\AdminPanel\Base\Contracts\Serializers\SimpleDataArraySerializerContract');

        $manager = new Manager();
        $manager->setSerializer($serializer);

        $transformation = $manager->createData($resource)->toArray();
        $transformation['success'] = ((bool) $transformation['id']);

        return response()->json($transformation);
    }
}
