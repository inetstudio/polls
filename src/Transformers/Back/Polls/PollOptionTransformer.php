<?php

namespace InetStudio\Polls\Transformers\Back\Polls;

use League\Fractal\TransformerAbstract;
use InetStudio\Polls\Contracts\Models\PollOptionModelContract;
use InetStudio\Polls\Contracts\Transformers\Back\Polls\PollOptionTransformerContract;

/**
 * Class PollOptionTransformer.
 */
class PollOptionTransformer extends TransformerAbstract implements PollOptionTransformerContract
{
    /**
     * Подготовка данных для отображения в таблице.
     *
     * @param PollOptionModelContract $item
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function transform(PollOptionModelContract $item): array
    {
        return [
            'id' => $item->id,
            'properties' => [
                'answer' => $item->answer,
            ],
        ];
    }
}
