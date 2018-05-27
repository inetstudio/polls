<?php

namespace InetStudio\Polls\Observers;

use InetStudio\Polls\Contracts\Models\PollModelContract;
use InetStudio\Polls\Contracts\Observers\PollObserverContract;

/**
 * Class PollObserver.
 */
class PollObserver implements PollObserverContract
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    protected $services;

    /**
     * PollObserver constructor.
     */
    public function __construct()
    {
        $this->services['pollsObserver'] = app()->make('InetStudio\Polls\Contracts\Services\Back\Polls\PollsObserverServiceContract');
    }

    /**
     * Событие "объект создается".
     *
     * @param PollModelContract $item
     */
    public function creating(PollModelContract $item): void
    {
        $this->services['pollsObserver']->creating($item);
    }

    /**
     * Событие "объект создан".
     *
     * @param PollModelContract $item
     */
    public function created(PollModelContract $item): void
    {
        $this->services['pollsObserver']->created($item);
    }

    /**
     * Событие "объект обновляется".
     *
     * @param PollModelContract $item
     */
    public function updating(PollModelContract $item): void
    {
        $this->services['pollsObserver']->updating($item);
    }

    /**
     * Событие "объект обновлен".
     *
     * @param PollModelContract $item
     */
    public function updated(PollModelContract $item): void
    {
        $this->services['pollsObserver']->updated($item);
    }

    /**
     * Событие "объект подписки удаляется".
     *
     * @param PollModelContract $item
     */
    public function deleting(PollModelContract $item): void
    {
        $this->services['pollsObserver']->deleting($item);
    }

    /**
     * Событие "объект удален".
     *
     * @param PollModelContract $item
     */
    public function deleted(PollModelContract $item): void
    {
        $this->services['pollsObserver']->deleted($item);
    }
}
