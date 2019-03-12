<?php

namespace InetStudio\PollsPackage\Options\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class PollsOptionsBindingsServiceProvider.
 */
class PollsOptionsBindingsServiceProvider extends ServiceProvider
{
    /**
    * @var  bool
    */
    protected $defer = true;

    /**
    * @var  array
    */
    public $bindings = [
        'InetStudio\PollsPackage\Options\Contracts\Models\PollOptionModelContract' => 'InetStudio\PollsPackage\Options\Models\PollOptionModel',
        'InetStudio\PollsPackage\Options\Contracts\Transformers\Back\Resource\ShowTransformerContract' => 'InetStudio\PollsPackage\Options\Transformers\Back\Resource\ShowTransformer',
        'InetStudio\PollsPackage\Options\Contracts\Services\Back\ResourceServiceContract' => 'InetStudio\PollsPackage\Options\Services\Back\ResourceService',
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
