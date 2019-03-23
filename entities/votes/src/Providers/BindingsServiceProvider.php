<?php

namespace InetStudio\PollsPackage\Votes\Providers;

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
        'InetStudio\PollsPackage\Votes\Contracts\Models\PollVoteModelContract' => 'InetStudio\PollsPackage\Votes\Models\PollVoteModel',
        'InetStudio\PollsPackage\Votes\Contracts\Services\Front\ItemsServiceContract' => 'InetStudio\PollsPackage\Votes\Services\Front\ItemsService',
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
