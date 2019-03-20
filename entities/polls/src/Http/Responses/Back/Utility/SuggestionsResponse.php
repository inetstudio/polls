<?php

namespace InetStudio\PollsPackage\Polls\Http\Responses\Back\Utility;

use League\Fractal\Manager;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Responsable;
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
     * @var string
     */
    protected $type;

    /**
     * SuggestionsResponse constructor.
     *
     * @param Collection $items
     * @param string $type
     */
    public function __construct(Collection $items, string $type = '')
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

        $serializer = app()->make('InetStudio\AdminPanel\Contracts\Serializers\SimpleDataArraySerializerContract');

        $manager = new Manager();
        $manager->setSerializer($serializer);

        $transformation = $manager->createData($resource)->toArray();

        $data = [
            'suggestions' => [],
            'items' => [],
        ];

        if ($this->type == 'autocomplete') {
            $data['suggestions'] = $transformation;
        } else {
            $data['items'] = $transformation;
        }

        return response()->json($data);
    }
}
