<?php

namespace InetStudio\PollsPackage\Polls\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract;
use InetStudio\PollsPackage\Polls\Contracts\Events\Back\ModifyItemEventContract;

/**
 * Class ModifyItemEvent.
 */
class ModifyItemEvent implements ModifyItemEventContract
{
    use SerializesModels;

    /**
     * @var PollModelContract
     */
    public $item;

    /**
     * ModifyItemEvent constructor.
     *
     * @param PollModelContract $item
     */
    public function __construct(PollModelContract $item)
    {
        $this->item = $item;
    }
}
