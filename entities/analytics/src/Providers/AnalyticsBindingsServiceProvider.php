<?php

namespace InetStudio\PollsPackage\Analytics\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class AnalyticsBindingsServiceProvider.
 */
class AnalyticsBindingsServiceProvider extends ServiceProvider
{
    /**
     * @var  bool
     */
    protected $defer = true;

    /**
     * @var  array
     */
    public $bindings = [
        'InetStudio\PollsPackage\Analytics\Contracts\Transformers\Back\Result\PollOptionTransformerContract' => 'InetStudio\PollsPackage\Analytics\Transformers\Back\Result\PollOptionTransformer',
        'InetStudio\PollsPackage\Analytics\Contracts\Transformers\Back\Result\PollTransformerContract' => 'InetStudio\PollsPackage\Analytics\Transformers\Back\Result\PollTransformer',
        'InetStudio\PollsPackage\Analytics\Contracts\Transformers\Back\PollTransformerContract' => 'InetStudio\PollsPackage\Analytics\Transformers\Back\PollTransformer',
        'InetStudio\PollsPackage\Analytics\Contracts\Http\Responses\Back\ResultResponseContract' => 'InetStudio\PollsPackage\Analytics\Http\Responses\Back\ResultResponse',
        'InetStudio\PollsPackage\Analytics\Contracts\Http\Responses\Back\IndexResponseContract' => 'InetStudio\PollsPackage\Analytics\Http\Responses\Back\IndexResponse',
        'InetStudio\PollsPackage\Analytics\Contracts\Http\Controllers\Back\AnalyticsControllerContract' => 'InetStudio\PollsPackage\Analytics\Http\Controllers\Back\AnalyticsController',
        'InetStudio\PollsPackage\Analytics\Contracts\Http\Controllers\Back\DataControllerContract' => 'InetStudio\PollsPackage\Analytics\Http\Controllers\Back\DataController',
        'InetStudio\PollsPackage\Analytics\Contracts\Services\Back\DataTableServiceContract' => 'InetStudio\PollsPackage\Analytics\Services\Back\DataTableService',
        'InetStudio\PollsPackage\Analytics\Contracts\Services\Back\AnalyticsServiceContract' => 'InetStudio\PollsPackage\Analytics\Services\Back\AnalyticsService',
    ];

    /**
     * Получить сервисы от провайдера.
     *
     * @return  array
     */
    public function provides()
    {
        return array_keys($this->bindings);
    }
}
