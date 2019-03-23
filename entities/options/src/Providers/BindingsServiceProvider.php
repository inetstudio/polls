<?php

namespace InetStudio\PollsPackage\Options\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class BindingsServiceProvider.
 */
class BindingsServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    /**
     * @var array
     */
    public $bindings = [
        'InetStudio\PollsPackage\Options\Contracts\Models\PollOptionModelContract' => 'InetStudio\PollsPackage\Options\Models\PollOptionModel',
        'InetStudio\PollsPackage\Options\Contracts\Transformers\Back\Resource\ShowTransformerContract' => 'InetStudio\PollsPackage\Options\Transformers\Back\Resource\ShowTransformer',
        'InetStudio\PollsPackage\Options\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\PollsPackage\Options\Services\Back\ItemsService',
    ];

    /**
     * Получить сервисы от провайдера.
     *
     * @return array
     */
    public function provides()
    {
        return array_keys($this->bindings);
    }
}
