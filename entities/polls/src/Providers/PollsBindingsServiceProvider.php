<?php

namespace InetStudio\PollsPackage\Polls\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class PollsBindingsServiceProvider.
 */
class PollsBindingsServiceProvider extends ServiceProvider
{
    /**
    * @var  bool
    */
    protected $defer = true;

    /**
    * @var  array
    */
    public $bindings = [
        'InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract' => 'InetStudio\PollsPackage\Polls\Models\PollModel',
        'InetStudio\PollsPackage\Polls\Contracts\Transformers\Back\Resource\IndexTransformerContract' => 'InetStudio\PollsPackage\Polls\Transformers\Back\Resource\IndexTransformer',
        'InetStudio\PollsPackage\Polls\Contracts\Transformers\Back\Resource\ShowTransformerContract' => 'InetStudio\PollsPackage\Polls\Transformers\Back\Resource\ShowTransformer',
        'InetStudio\PollsPackage\Polls\Contracts\Transformers\Back\Utility\SuggestionTransformerContract' => 'InetStudio\PollsPackage\Polls\Transformers\Back\Utility\SuggestionTransformer',
        'InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Back\Resource\DestroyResponseContract' => 'InetStudio\PollsPackage\Polls\Http\Responses\Back\Resource\DestroyResponse',
        'InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Back\Resource\SaveResponseContract' => 'InetStudio\PollsPackage\Polls\Http\Responses\Back\Resource\SaveResponse',
        'InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Back\Resource\ShowResponseContract' => 'InetStudio\PollsPackage\Polls\Http\Responses\Back\Resource\ShowResponse',
        'InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Back\Resource\IndexResponseContract' => 'InetStudio\PollsPackage\Polls\Http\Responses\Back\Resource\IndexResponse',
        'InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Back\Resource\FormResponseContract' => 'InetStudio\PollsPackage\Polls\Http\Responses\Back\Resource\FormResponse',
        'InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract' => 'InetStudio\PollsPackage\Polls\Http\Responses\Back\Utility\SuggestionsResponse',
        'InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Front\VoteResponseContract' => 'InetStudio\PollsPackage\Polls\Http\Responses\Front\VoteResponse',
        'InetStudio\PollsPackage\Polls\Contracts\Http\Requests\Back\SaveItemRequestContract' => 'InetStudio\PollsPackage\Polls\Http\Requests\Back\SaveItemRequest',
        'InetStudio\PollsPackage\Polls\Contracts\Http\Controllers\Back\DataControllerContract' => 'InetStudio\PollsPackage\Polls\Http\Controllers\Back\DataController',
        'InetStudio\PollsPackage\Polls\Contracts\Http\Controllers\Back\ResourceControllerContract' => 'InetStudio\PollsPackage\Polls\Http\Controllers\Back\ResourceController',
        'InetStudio\PollsPackage\Polls\Contracts\Http\Controllers\Back\UtilityControllerContract' => 'InetStudio\PollsPackage\Polls\Http\Controllers\Back\UtilityController',
        'InetStudio\PollsPackage\Polls\Contracts\Http\Controllers\Front\PollsControllerContract' => 'InetStudio\PollsPackage\Polls\Http\Controllers\Front\PollsController',
        'InetStudio\PollsPackage\Polls\Contracts\Events\Back\ModifyItemEventContract' => 'InetStudio\PollsPackage\Polls\Events\Back\ModifyItemEvent',
        'InetStudio\PollsPackage\Polls\Contracts\Services\Back\ResourceServiceContract' => 'InetStudio\PollsPackage\Polls\Services\Back\ResourceService',
        'InetStudio\PollsPackage\Polls\Contracts\Services\Back\UtilityServiceContract' => 'InetStudio\PollsPackage\Polls\Services\Back\UtilityService',
        'InetStudio\PollsPackage\Polls\Contracts\Services\Back\DataTableServiceContract' => 'InetStudio\PollsPackage\Polls\Services\Back\DataTableService',
        'InetStudio\PollsPackage\Polls\Contracts\Services\Front\PollsServiceContract' => 'InetStudio\PollsPackage\Polls\Services\Front\PollsService',
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
