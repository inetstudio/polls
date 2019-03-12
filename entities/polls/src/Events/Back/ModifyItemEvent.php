<?php

namespace InetStudio\PollsPackage\Polls\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\PollsPackage\Polls\Contracts\Events\Back\ModifyItemEventContract;

/**
 * Class ModifyItemEvent.
 */
class ModifyItemEvent implements ModifyItemEventContract
{
    use SerializesModels;

    /**
     * @var
     */
    public $item;

    /**
     * ModifyItemEvent constructor.
     *
     * @param $item
     */
    public function __construct($item)
    {
        $this->item = $item;
    }
}
