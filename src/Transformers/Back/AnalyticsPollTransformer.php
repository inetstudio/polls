<?php

namespace InetStudio\Polls\Transformers\Back;

use InetStudio\Polls\Models\PollModel;
use League\Fractal\TransformerAbstract;

class AnalyticsPollTransformer extends TransformerAbstract
{
    /**
     * Подготовка данных для отображения в таблице.
     *
     * @param PollModel $poll
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function transform(PollModel $poll): array
    {
        return [
            'id' => (int) $poll->id,
            'question' => $poll->question,
            'voters' => $poll->options->sum('votes_count'),
            'results' => view('admin.module.polls::back.partials.datatables.results', [
                'id' => $poll->id,
            ])->render(),
        ];
    }
}
