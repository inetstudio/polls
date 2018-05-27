<?php

namespace InetStudio\Polls\Transformers\Back\Polls;

use League\Fractal\TransformerAbstract;
use InetStudio\Polls\Contracts\Models\PollModelContract;
use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\Polls\Contracts\Transformers\Back\Polls\ShowPollTransformerContract;

/**
 * Class ShowPollTransformer.
 */
class ShowPollTransformer extends TransformerAbstract implements ShowPollTransformerContract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'options',
    ];

    /**
     * Подготовка данных для отображения в таблице.
     *
     * @param PollModelContract $item
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function transform(PollModelContract $item): array
    {
        return [
            'id' => $item->id,
            'question' => $item->question,
        ];
    }

    /**
     * Включаем ответы в трасформацию.
     *
     * @param PollModelContract $item
     *
     * @return FractalCollection
     */
    public function includeOptions(PollModelContract $item)
    {
        return new FractalCollection($item->getAttribute('options'), app()->make('InetStudio\Polls\Contracts\Transformers\Back\Polls\PollOptionTransformerContract'));
    }
}
