<?php

namespace Inetstudio\Polls\Transformers;

use InetStudio\Polls\Models\PollModel;
use League\Fractal\TransformerAbstract;

class PollTransformer extends TransformerAbstract
{
    /**
     * Подготовка данных для отображения в таблице.
     *
     * @param PollModel $poll
     * @return array
     * @throws \Throwable
     */
    public function transform(PollModel $poll): array
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
