<?php

namespace InetStudio\PollsPackage\Polls\Contracts\Http\Controllers\Back;

use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use InetStudio\PollsPackage\Polls\Contracts\Services\Back\UtilityServiceContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract;

/**
 * Interface UtilityControllerContract.
 */
interface UtilityControllerContract
{
    /**
     * Возвращаем статьи для поля.
     *
     * @param Application $app
     * @param UtilityServiceContract $utilityService
     * @param Request $request
     *
     * @return SuggestionsResponseContract
     */
    public function getSuggestions(Application $app,
                                   UtilityServiceContract $utilityService,
                                   Request $request): SuggestionsResponseContract;
}
