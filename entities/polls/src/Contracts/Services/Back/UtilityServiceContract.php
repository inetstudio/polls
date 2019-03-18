<?php

namespace InetStudio\PollsPackage\Polls\Contracts\Services\Back;

use Illuminate\Support\Collection;

/**
 * Interface UtilityServiceContract.
 */
interface UtilityServiceContract
{
    /**
     * Получаем подсказки.
     *
     * @param string $search
     *
     * @return Collection
     */
    public function getSuggestions(string $search): Collection;
}
