<?php

namespace InetStudio\PollsPackage\Polls\Contracts\Transformers\Back\Resource;

use InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract;

/**
 * Interface IndexTransformerContract.
 */
interface IndexTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param PollModelContract $item
     *
     * @return array
     */
    public function transform(PollModelContract $item): array;
}
