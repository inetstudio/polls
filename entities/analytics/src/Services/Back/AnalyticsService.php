<?php

namespace InetStudio\PollsPackage\Analytics\Services\Back;

use InetStudio\AdminPanel\Base\Services\BaseService;
use InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract;
use InetStudio\PollsPackage\Analytics\Contracts\Services\Back\AnalyticsServiceContract;

/**
 * Class AnalyticsService.
 */
class AnalyticsService extends BaseService implements AnalyticsServiceContract
{
    /**
     * AnalyticsService constructor.
     *
     * @param PollModelContract $model
     */
    public function __construct(PollModelContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Возвращаем статьи, в которых содержится опрос.
     *
     * @param int $id
     *
     * @return array
     */
    public function getArticlesWithPoll(int $id): array
    {
        $widgetsService = app()->make('InetStudio\Widgets\Contracts\Services\Back\WidgetsServiceContract');
        $articlesService = app()->make('InetStudio\Articles\Contracts\Services\Back\ArticlesServiceContract');

        $widgetsWithPoll = $widgetsService->model::where([
            ['view', '=', 'admin.module.polls::front.partials.content.poll_widget'],
            ['params', 'like', '%'.$id.'%'],
        ])->get();

        $items = [];
        foreach ($widgetsWithPoll ?? [] as $widget) {
            $articles = $articlesService->model::where([
                ['content', 'like', '%data-type="poll" data-id="'.$widget->id.'"%'],
            ])->get();

            foreach ($articles as $article) {
                $items[] = [
                    'id' => $article->id,
                    'title' => $article->title,
                    'href' => url($article->href),
                ];
            }
        }

        return collect($items)->unique('id')->toArray();
    }
}
