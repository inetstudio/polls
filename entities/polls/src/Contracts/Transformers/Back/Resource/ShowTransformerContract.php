<?php

namespace InetStudio\PollsPackage\Polls\Contracts\Transformers\Back\Resource;

use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract;

/**
 * Interface ShowTransformerContract.
 */
interface ShowTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param PollModelContract $item
     *
     * @return array
     */
    public function transform(PollModelContract $item): array;

    /**
     * Включаем ответы в трансформацию.
     *
     * @param PollModelContract $item
     *
     * @return FractalCollection
     */
    public function includeOptions(PollModelContract $item): FractalCollection;
}
