<?php

namespace InetStudio\PollsPackage\Polls\Transformers\Back\Resource;

use Throwable;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection as FractalCollection;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract;
use InetStudio\PollsPackage\Polls\Contracts\Transformers\Back\Resource\ShowTransformerContract;

/**
 * Class ShowTransformer.
 */
class ShowTransformer extends TransformerAbstract implements ShowTransformerContract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'options',
    ];

    /**
     * Трансформация данных.
     *
     * @param  PollModelContract  $item
     *
     * @return array
     *
     * @throws Throwable
     */
    public function transform(PollModelContract $item): array
    {
        return [
            'id' => $item['id'],
            'question' => $item['question'],
        ];
    }

    /**
     * Включаем ответы в трансформацию.
     *
     * @param  PollModelContract  $item
     *
     * @return FractalCollection
     *
     * @throws BindingResolutionException
     */
    public function includeOptions(PollModelContract $item): FractalCollection
    {
        $transformer = app()->make(
            'InetStudio\PollsPackage\Options\Contracts\Transformers\Back\Resource\ShowTransformerContract'
        );

        return new FractalCollection($item['options'], $transformer);
    }
}
