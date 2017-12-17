<?php

namespace InetStudio\Polls\Listeners;

use Illuminate\Support\Facades\Cache;

/**
 * Class ClearPollsCacheListener
 * @package InetStudio\Tags\Listeners
 */
class ClearPollsCacheListener
{
    /**
     * ClearTagsCacheListener constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * Обработка события.
     *
     * @param $event
     */
    public function handle($event): void
    {
        $object = $event->object;

        Cache::tags(['polls'])->forget('PollsService_getPollById_'.md5($object->id));
    }
}
