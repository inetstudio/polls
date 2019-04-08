<?php

namespace InetStudio\PollsPackage\Options\Contracts\Transformers\Back\Resource;

use InetStudio\PollsPackage\Options\Contracts\Models\PollOptionModelContract;

/**
 * Interface ShowTransformerContract.
 */
interface ShowTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param  PollOptionModelContract  $item
     *
     * @return array
     */
    public function transform(PollOptionModelContract $item): array;
}
