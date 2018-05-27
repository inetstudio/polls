<?php

namespace InetStudio\Polls\Transformers\Back\Analytics;

use League\Fractal\TransformerAbstract;
use InetStudio\Polls\Contracts\Models\PollModelContract;
use InetStudio\Polls\Contracts\Transformers\Back\Analytics\PollTransformerContract;

class PollTransformer extends TransformerAbstract implements PollTransformerContract
{
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
            'id' => (int) $item->id,
            'question' => $item->question,
            'voters' => $item->options->sum('votes_count'),
            'results' => view('admin.module.polls::back.partials.datatables.result', [
                'id' => $item->id,
            ])->render(),
        ];
    }
}
