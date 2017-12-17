<?php

namespace InetStudio\Polls\Events;

use Illuminate\Queue\SerializesModels;

/**
 * Class ModifyPollEvent
 * @package InetStudio\Tags\Events
 */
class ModifyPollEvent
{
    use SerializesModels;

    /**
     * Объект опроса.
     *
     * @var
     */
    public $object;

    /**
     * Create a new event instance.
     *
     * ModifyPollEvent constructor.
     * @param $object
     */
    public function __construct($object)
    {
        $this->object = $object;
    }
}
