<?php

namespace InetStudio\PollsPackage\Analytics\Transformers\Back;

use Throwable;
use League\Fractal\TransformerAbstract;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\PollsPackage\Analytics\Contracts\Transformers\Back\PollTransformerContract;

/**
 * Class PollTransformer.
 */
class PollTransformer extends TransformerAbstract implements PollTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param  object  $item
     *
     * @return array
     *
     * @throws BindingResolutionException
     * @throws Throwable
     */
    public function transform($item): array
    {
        $analyticsService = app()->make(
            'InetStudio\PollsPackage\Analytics\Contracts\Services\Back\AnalyticsServiceContract'
        );

        return [
            'id' => (int) $item->id,
            'question' => $item->question,
            'votes_count' => $item->votes_count,
            'articles' => view(
                'admin.module.polls.analytics::back.partials.datatables.articles',
                [
                    'items' => $analyticsService->getArticlesWithPoll($item->id),
                ]
            )->render(),
            'results' => view(
                'admin.module.polls.analytics::back.partials.datatables.result',
                [
                    'id' => $item->id,
                ]
            )->render(),
        ];
    }
}
