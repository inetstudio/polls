<?php

namespace InetStudio\PollsPackage\Polls\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use InetStudio\PollsPackage\Polls\Contracts\Services\Back\UtilityServiceContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Controllers\Back\UtilityControllerContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract;

/**
 * Class UtilityController.
 */
class UtilityController extends Controller implements UtilityControllerContract
{
    /**
     * Возвращаем статьи для поля.
     *
     * @param UtilityServiceContract $utilityService
     * @param Request $request
     *
     * @return SuggestionsResponseContract
     */
    public function getSuggestions(UtilityServiceContract $utilityService, Request $request): SuggestionsResponseContract
    {
        $search = $request->get('q');
        $type = $request->get('type') ?? '';

        $items = $utilityService->getSuggestions($search);

        return app()->makeWith(
            SuggestionsResponseContract::class,
            compact('items', 'type')
        );
    }
}