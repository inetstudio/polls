<?php

namespace InetStudio\PollsPackage\Analytics\Contracts\Transformers\Back\Result;

use InetStudio\PollsPackage\Options\Contracts\Models\PollOptionModelContract;

/**
 * Interface PollOptionTransformerContract.
 */
interface PollOptionTransformerContract
{
    /**
     * @param  PollOptionModelContract  $item
     *
     * @return array
     */
    public function transform(PollOptionModelContract $item): array;
}
