<?php

namespace InetStudio\PollsPackage\Analytics\Transformers\Back;

use League\Fractal\TransformerAbstract;
use InetStudio\PollsPackage\Analytics\Contracts\Transformers\Back\PollTransformerContract;

/**
 * Class PollTransformer.
 */
class PollTransformer extends TransformerAbstract implements PollTransformerContract
{
    /**
     * Подготовка данных для отображения в таблице.
     *
     * @param object $item
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function transform($item): array
    {
        $analyticsService = app()->make('InetStudio\PollsPackage\Analytics\Contracts\Services\Back\AnalyticsServiceContract');

        return [
            'id' => (int) $item->id,
            'question' => $item->question,
            'votes_count' => $item->votes_count,
            'articles' => view('admin.module.polls.analytics::back.partials.datatables.articles', [
                'items' => $analyticsService->getArticlesWithPoll($item->id),
            ])->render(),
            'results' => view('admin.module.polls.analytics::back.partials.datatables.result', [
                'id' => $item->id,
            ])->render(),
        ];
    }
}
