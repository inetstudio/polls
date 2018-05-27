<?php

namespace InetStudio\Polls\Transformers\Back\Polls;

use League\Fractal\TransformerAbstract;
use InetStudio\Polls\Contracts\Models\PollModelContract;
use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\Polls\Contracts\Transformers\Back\Polls\SuggestionTransformerContract;

/**
 * Class SuggestionTransformer.
 */
class SuggestionTransformer extends TransformerAbstract implements SuggestionTransformerContract
{
    /**
     * @var string
     */
    private $type;

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
     * Подготовка данных для отображения в выпадающих списках.
     *
     * @param PollModelContract $item
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function transform(PollModelContract $item): array
    {
        if ($this->type && $this->type == 'autocomplete') {
            return [
                'value' => $item->question,
                'data' => [
                    'id' => $item->id,
                    'name' => $item->question,
                ],
            ];
        } else {
            return [
                'id' => $item->id,
                'name' => $item->question,
            ];
        }
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
