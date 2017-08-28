<?php

namespace Inetstudio\Polls\Transformers;

use League\Fractal\TransformerAbstract;
use InetStudio\Polls\Models\PollModel;

class PollTransformer extends TransformerAbstract
{
    /**
     * @param PollModel $poll
     * @return array
     */
    public function transform(PollModel $poll)
    {
        return [
            'id' => (int) $poll->id,
            'question' => $poll->question,
            'created_at' => (string) $poll->created_at,
            'updated_at' => (string) $poll->updated_at,
            'actions' => view('admin.module.polls::partials.datatables.actions', ['id' => $poll->id])->render(),
        ];
    }
}
