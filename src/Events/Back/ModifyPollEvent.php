<?php

namespace InetStudio\Polls\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\Polls\Contracts\Events\Back\ModifyPollEventContract;

/**
 * Class ModifyPollEvent.
 */
class ModifyPollEvent implements ModifyPollEventContract
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
