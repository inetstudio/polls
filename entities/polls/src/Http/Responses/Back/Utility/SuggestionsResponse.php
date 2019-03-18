<?php

namespace InetStudio\PollsPackage\Polls\Http\Responses\Back\Utility;

use League\Fractal\Manager;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Responsable;
use League\Fractal\Serializer\DataArraySerializer;
use InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract;

/**
 * Class SuggestionsResponse.
 */
class SuggestionsResponse implements SuggestionsResponseContract, Responsable
{
    /**
     * @var Collection
     */
    protected $items;

    /**
     * @var mixed
     */
    protected $type;

    /**
     * SuggestionsResponse constructor.
     *
     * @param Collection $items
     * @param mixed $type
     */
    public function __construct(Collection $items, $type)
    {
        $this->items = $items;
        $this->type = $type;
    }

    /**
     * Возвращаем подсказки для поля.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        $resource = (app()->makeWith('InetStudio\PollsPackage\Polls\Contracts\Transformers\Back\Utility\SuggestionTransformerContract', [
            'type' => $this->type,
        ]))->transformCollection($this->items);

        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());

        $transformation = $manager->createData($resource)->toArray();

        $data = [
            'suggestions' => [],
            'items' => [],
        ];

        if ($this->type && $this->type == 'autocomplete') {
            $data['suggestions'] = $transformation['data'];
        } else {
            $data['items'] = $transformation['data'];
        }

        return response()->json($data);
    }
}
