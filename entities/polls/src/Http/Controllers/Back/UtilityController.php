<?php

namespace InetStudio\PollsPackage\Polls\Http\Controllers\Back;

use Illuminate\Http\Request;
use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\PollsPackage\Polls\Contracts\Services\Back\UtilityServiceContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Controllers\Back\UtilityControllerContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract;

/**
 * Class UtilityController.
 */
class UtilityController extends Controller implements UtilityControllerContract
{
    /**
     * Возвращаем опросы для поля.
     *
     * @param UtilityServiceContract $utilityService
     * @param Request $request
     *
     * @return SuggestionsResponseContract
     */
    public function getSuggestions(UtilityServiceContract $utilityService,
                                   Request $request): SuggestionsResponseContract
    {
        $search = $request->get('q', '');
        $type = $request->get('type', '');

        $items = $utilityService->getSuggestions($search);

        return $this->app->make(SuggestionsResponseContract::class, compact('items', 'type'));
    }
}
