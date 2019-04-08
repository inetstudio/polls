<?php

namespace InetStudio\PollsPackage\Polls\Contracts\Http\Controllers\Back;

use Illuminate\Http\Request;
use InetStudio\PollsPackage\Polls\Contracts\Services\Back\UtilityServiceContract;
use InetStudio\PollsPackage\Polls\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract;

/**
 * Interface UtilityControllerContract.
 */
interface UtilityControllerContract
{
    /**
     * Возвращаем опросы для поля.
     *
     * @param  UtilityServiceContract  $utilityService
     * @param  Request  $request
     *
     * @return SuggestionsResponseContract
     */
    public function getSuggestions(
        UtilityServiceContract $utilityService,
        Request $request
    ): SuggestionsResponseContract;
}
