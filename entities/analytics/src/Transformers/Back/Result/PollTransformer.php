<?php

namespace InetStudio\PollsPackage\Analytics\Transformers\Back\Result;

use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection as FractalCollection;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract;
use InetStudio\PollsPackage\Analytics\Contracts\Transformers\Back\Result\PollTransformerContract;

/**
 * Class PollTransformer.
 */
class PollTransformer extends TransformerAbstract implements PollTransformerContract
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
     */
    public function transform(PollModelContract $item): array
    {
        return [
            'id' => (int) $item['id'],
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
            'InetStudio\PollsPackage\Analytics\Contracts\Transformers\Back\Result\PollOptionTransformerContract',
            [
                'totalVotes' => $item['options']->sum('votes_count'),
            ]
        );

        return new FractalCollection($item['options'], $transformer);
    }
}
