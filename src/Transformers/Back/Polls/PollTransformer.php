<?php

namespace InetStudio\Polls\Transformers\Back\Polls;

use League\Fractal\TransformerAbstract;
use InetStudio\Polls\Contracts\Models\PollModelContract;
use InetStudio\Polls\Contracts\Transformers\Back\Polls\PollTransformerContract;

/**
 * Class PollTransformer.
 */
class PollTransformer extends TransformerAbstract implements PollTransformerContract
{
    /**
     * Подготовка данных для отображения в таблице.
     *
     * @param PollModelContract $poll
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function transform(PollModelContract $poll): array
    {
        return [
            'id' => (int) $poll->id,
            'question' => $poll->question,
            'created_at' => (string) $poll->created_at,
            'updated_at' => (string) $poll->updated_at,
            'actions' => view('admin.module.polls::back.partials.datatables.actions', [
                'id' => $poll->id,
            ])->render(),
        ];
    }
}
