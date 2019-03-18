<?php

namespace InetStudio\PollsPackage\Polls\Transformers\Back\Utility;

use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract;
use InetStudio\PollsPackage\Polls\Contracts\Transformers\Back\Utility\SuggestionTransformerContract;

/**
 * Class SuggestionTransformer.
 */
class SuggestionTransformer extends TransformerAbstract implements SuggestionTransformerContract
{
    /**
     * @var string
     */
    protected $type;

    /**
     * SuggestionTransformer constructor.
     *
     * @param $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * Подготовка данных.
     *
     * @param PollModelContract $item
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function transform(PollModelContract $item): array
    {
        return ($this->type && $this->type == 'autocomplete') ? [
            'value' => $item['question'],
            'data' => [
                'id' => $item['id'],
                'name' => $item['question'],
            ],
        ] : [
            'id' => $item['id'],
            'name' => $item['question'],
        ];
    }

    /**
     * Обработка коллекции объектов.
     *
     * @param $items
     *
     * @return FractalCollection
     */
    public function transformCollection($items): FractalCollection
    {
        return new FractalCollection($items, $this);
    }
}
