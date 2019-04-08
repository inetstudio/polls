<?php

namespace InetStudio\PollsPackage\Analytics\Contracts\Transformers\Back\Result;

use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract;

/**
 * Interface PollTransformerContract.
 */
interface PollTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param  PollModelContract  $item
     *
     * @return array
     */
    public function transform(PollModelContract $item): array;

    /**
     * Включаем ответы в трансформацию.
     *
     * @param  PollModelContract  $item
     *
     * @return FractalCollection
     */
    public function includeOptions(PollModelContract $item): FractalCollection;
}
