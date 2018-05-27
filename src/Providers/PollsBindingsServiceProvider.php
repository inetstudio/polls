<?php

namespace InetStudio\Polls\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class PollsBindingsServiceProvider.
 */
class PollsBindingsServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public $bindings = [
        // Controllers
        'InetStudio\Polls\Contracts\Http\Controllers\Back\Analytics\PollsControllerContract' => 'InetStudio\Polls\Http\Controllers\Back\Analytics\PollsController',
        'InetStudio\Polls\Contracts\Http\Controllers\Back\Analytics\PollsDataControllerContract' => 'InetStudio\Polls\Http\Controllers\Back\Analytics\PollsDataController',
        'InetStudio\Polls\Contracts\Http\Controllers\Back\Polls\PollsControllerContract' => 'InetStudio\Polls\Http\Controllers\Back\Polls\PollsController',
        'InetStudio\Polls\Contracts\Http\Controllers\Back\Polls\PollsDataControllerContract' => 'InetStudio\Polls\Http\Controllers\Back\Polls\PollsDataController',
        'InetStudio\Polls\Contracts\Http\Controllers\Back\Polls\PollsUtilityControllerContract' => 'InetStudio\Polls\Http\Controllers\Back\Polls\PollsUtilityController',
        'InetStudio\Polls\Contracts\Http\Controllers\Front\Polls\PollsControllerContract' => 'InetStudio\Polls\Http\Controllers\Front\Polls\PollsController',

        // Events
        'InetStudio\Polls\Contracts\Events\Back\ModifyPollEventContract' => 'InetStudio\Polls\Events\Back\ModifyPollEvent',

        // Models
        'InetStudio\Polls\Contracts\Models\PollModelContract' => 'InetStudio\Polls\Models\PollModel',
        'InetStudio\Polls\Contracts\Models\PollOptionModelContract' => 'InetStudio\Polls\Models\PollOptionModel',
        'InetStudio\Polls\Contracts\Models\PollVoteModelContract' => 'InetStudio\Polls\Models\PollVoteModel',

        // Observers
        'InetStudio\Polls\Contracts\Observers\PollObserverContract' => 'InetStudio\Polls\Observers\PollObserver',

        // Repositories
        'InetStudio\Polls\Contracts\Repositories\PollsRepositoryContract' => 'InetStudio\Polls\Repositories\PollsRepository',
        'InetStudio\Polls\Contracts\Repositories\PollsOptionsRepositoryContract' => 'InetStudio\Polls\Repositories\PollsOptionsRepository',
        'InetStudio\Polls\Contracts\Repositories\PollsVotesRepositoryContract' => 'InetStudio\Polls\Repositories\PollsVotesRepository',

        // Requests
        'InetStudio\Polls\Contracts\Http\Requests\Back\Polls\SavePollRequestContract' => 'InetStudio\Polls\Http\Requests\Back\Polls\SavePollRequest',

        // Responses
        'InetStudio\Polls\Contracts\Http\Responses\Back\Analytics\IndexResponseContract' => 'InetStudio\Polls\Http\Responses\Back\Analytics\IndexResponse',
        'InetStudio\Polls\Contracts\Http\Responses\Back\Analytics\ResultResponseContract' => 'InetStudio\Polls\Http\Responses\Back\Analytics\ResultResponse',
        'InetStudio\Polls\Contracts\Http\Responses\Back\Polls\DestroyResponseContract' => 'InetStudio\Polls\Http\Responses\Back\Polls\DestroyResponse',
        'InetStudio\Polls\Contracts\Http\Responses\Back\Polls\FormResponseContract' => 'InetStudio\Polls\Http\Responses\Back\Polls\FormResponse',
        'InetStudio\Polls\Contracts\Http\Responses\Back\Polls\IndexResponseContract' => 'InetStudio\Polls\Http\Responses\Back\Polls\IndexResponse',
        'InetStudio\Polls\Contracts\Http\Responses\Back\Polls\SaveResponseContract' => 'InetStudio\Polls\Http\Responses\Back\Polls\SaveResponse',
        'InetStudio\Polls\Contracts\Http\Responses\Back\Polls\ShowResponseContract' => 'InetStudio\Polls\Http\Responses\Back\Polls\ShowResponse',
        'InetStudio\Polls\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract' => 'InetStudio\Polls\Http\Responses\Back\Utility\SuggestionsResponse',
        'InetStudio\Polls\Contracts\Http\Responses\Front\Polls\VoteResponseContract' => 'InetStudio\Polls\Http\Responses\Front\Polls\VoteResponse',

        // Services
        'InetStudio\Polls\Contracts\Services\Back\Analytics\PollsDataTableServiceContract' => 'InetStudio\Polls\Services\Back\Analytics\PollsDataTableService',
        'InetStudio\Polls\Contracts\Services\Back\Polls\PollsDataTableServiceContract' => 'InetStudio\Polls\Services\Back\Polls\PollsDataTableService',
        'InetStudio\Polls\Contracts\Services\Back\Polls\PollsObserverServiceContract' => 'InetStudio\Polls\Services\Back\Polls\PollsObserverService',
        'InetStudio\Polls\Contracts\Services\Back\Polls\PollsServiceContract' => 'InetStudio\Polls\Services\Back\Polls\PollsService',
        'InetStudio\Polls\Contracts\Services\Back\PollsOptions\PollsOptionsServiceContract' => 'InetStudio\Polls\Services\Back\PollsOptions\PollsOptionsService',
        'InetStudio\Polls\Contracts\Services\Front\Polls\PollsServiceContract' => 'InetStudio\Polls\Services\Front\Polls\PollsService',

        // Transformers
        'InetStudio\Polls\Contracts\Transformers\Back\Analytics\PollTransformerContract' => 'InetStudio\Polls\Transformers\Back\Analytics\PollTransformer',
        'InetStudio\Polls\Contracts\Transformers\Back\Polls\PollTransformerContract' => 'InetStudio\Polls\Transformers\Back\Polls\PollTransformer',
        'InetStudio\Polls\Contracts\Transformers\Back\Polls\PollOptionTransformerContract' => 'InetStudio\Polls\Transformers\Back\Polls\PollOptionTransformer',
        'InetStudio\Polls\Contracts\Transformers\Back\Polls\ShowPollTransformerContract' => 'InetStudio\Polls\Transformers\Back\Polls\ShowPollTransformer',
        'InetStudio\Polls\Contracts\Transformers\Back\Polls\SuggestionTransformerContract' => 'InetStudio\Polls\Transformers\Back\Polls\SuggestionTransformer',
    ];

    /**
     * Получить сервисы от провайдера.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'InetStudio\Polls\Contracts\Http\Controllers\Back\Analytics\PollsControllerContract',
            'InetStudio\Polls\Contracts\Http\Controllers\Back\Analytics\PollsDataControllerContract',
            'InetStudio\Polls\Contracts\Http\Controllers\Back\Polls\PollsControllerContract',
            'InetStudio\Polls\Contracts\Http\Controllers\Back\Polls\PollsDataControllerContract',
            'InetStudio\Polls\Contracts\Http\Controllers\Back\Polls\PollsUtilityControllerContract',
            'InetStudio\Polls\Contracts\Http\Controllers\Front\Polls\PollsControllerContract',
            'InetStudio\Polls\Contracts\Events\Back\ModifyPollEventContract',
            'InetStudio\Polls\Contracts\Models\PollModelContract',
            'InetStudio\Polls\Contracts\Models\PollOptionModelContract',
            'InetStudio\Polls\Contracts\Models\PollVoteModelContract',
            'InetStudio\Polls\Contracts\Observers\PollObserverContract',
            'InetStudio\Polls\Contracts\Repositories\PollsRepositoryContract',
            'InetStudio\Polls\Contracts\Repositories\PollsOptionsRepositoryContract',
            'InetStudio\Polls\Contracts\Repositories\PollsVotesRepositoryContract',
            'InetStudio\Polls\Contracts\Http\Requests\Back\Polls\SavePollRequestContract',
            'InetStudio\Polls\Contracts\Http\Responses\Back\Analytics\IndexResponseContract',
            'InetStudio\Polls\Contracts\Http\Responses\Back\Analytics\ResultResponseContract',
            'InetStudio\Polls\Contracts\Http\Responses\Back\Polls\DestroyResponseContract',
            'InetStudio\Polls\Contracts\Http\Responses\Back\Polls\FormResponseContract',
            'InetStudio\Polls\Contracts\Http\Responses\Back\Polls\IndexResponseContract',
            'InetStudio\Polls\Contracts\Http\Responses\Back\Polls\SaveResponseContract',
            'InetStudio\Polls\Contracts\Http\Responses\Back\Polls\ShowResponseContract',
            'InetStudio\Polls\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract',
            'InetStudio\Polls\Contracts\Http\Responses\Front\Polls\VoteResponseContract',
            'InetStudio\Polls\Contracts\Services\Back\Analytics\PollsDataTableServiceContract',
            'InetStudio\Polls\Contracts\Services\Back\Polls\PollsDataTableServiceContract',
            'InetStudio\Polls\Contracts\Services\Back\Polls\PollsObserverServiceContract',
            'InetStudio\Polls\Contracts\Services\Back\Polls\PollsServiceContract',
            'InetStudio\Polls\Contracts\Services\Back\PollsOptions\PollsOptionsServiceContract',
            'InetStudio\Polls\Contracts\Services\Front\Polls\PollsServiceContract',
            'InetStudio\Polls\Contracts\Transformers\Back\Analytics\PollTransformerContract',
            'InetStudio\Polls\Contracts\Transformers\Back\Polls\PollTransformerContract',
            'InetStudio\Polls\Contracts\Transformers\Back\Polls\PollOptionTransformerContract',
            'InetStudio\Polls\Contracts\Transformers\Back\Polls\ShowPollTransformerContract',
            'InetStudio\Polls\Contracts\Transformers\Back\Polls\SuggestionTransformerContract',
        ];
    }
}
