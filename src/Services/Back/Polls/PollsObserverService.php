<?php

namespace InetStudio\Polls\Services\Back\Polls;

use InetStudio\Polls\Contracts\Models\PollModelContract;
use InetStudio\Polls\Contracts\Repositories\PollsRepositoryContract;
use InetStudio\Polls\Contracts\Services\Back\Polls\PollsObserverServiceContract;

/**
 * Class PollsObserverService.
 */
class PollsObserverService implements PollsObserverServiceContract
{
    /**
     * @var PollsRepositoryContract
     */
    private $repository;

    /**
     * PollsService constructor.
     *
     * @param PollsRepositoryContract $repository
     */
    public function __construct(PollsRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Событие "объект создается".
     *
     * @param PollModelContract $item
     */
    public function creating(PollModelContract $item): void
    {
    }

    /**
     * Событие "объект создан".
     *
     * @param PollModelContract $item
     */
    public function created(PollModelContract $item): void
    {
    }

    /**
     * Событие "объект обновляется".
     *
     * @param PollModelContract $item
     */
    public function updating(PollModelContract $item): void
    {
    }

    /**
     * Событие "объект обновлен".
     *
     * @param PollModelContract $item
     */
    public function updated(PollModelContract $item): void
    {
    }

    /**
     * Событие "объект подписки удаляется".
     *
     * @param PollModelContract $item
     */
    public function deleting(PollModelContract $item): void
    {
    }

    /**
     * Событие "объект удален".
     *
     * @param PollModelContract $item
     */
    public function deleted(PollModelContract $item): void
    {
    }
}
