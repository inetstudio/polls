<?php

namespace InetStudio\PollsPackage\Votes\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class PollsVotesBindingsServiceProvider.
 */
class PollsVotesBindingsServiceProvider extends ServiceProvider
{
    /**
    * @var  bool
    */
    protected $defer = true;

    /**
    * @var  array
    */
    public $bindings = [
        'InetStudio\PollsPackage\Votes\Contracts\Models\PollVoteModelContract' => 'InetStudio\PollsPackage\Votes\Models\PollVoteModel',
        'InetStudio\PollsPackage\Votes\Contracts\Services\Front\PollsVotesServiceContract' => 'InetStudio\PollsPackage\Votes\Services\Front\PollsVotesService',
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
