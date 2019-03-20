<?php

namespace InetStudio\PollsPackage\Analytics\Contracts\Transformers\Back;

/**
 * Interface PollTransformerContract.
 */
interface PollTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param object $item
     *
     * @return array
     */
    public function transform($item): array;
}
