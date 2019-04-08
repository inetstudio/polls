<?php

namespace InetStudio\PollsPackage\Options\Transformers\Back\Resource;

use Throwable;
use League\Fractal\TransformerAbstract;
use InetStudio\PollsPackage\Options\Contracts\Models\PollOptionModelContract;
use InetStudio\PollsPackage\Options\Contracts\Transformers\Back\Resource\ShowTransformerContract;

/**
 * Class ShowTransformer.
 */
class ShowTransformer extends TransformerAbstract implements ShowTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param  PollOptionModelContract  $item
     *
     * @return array
     *
     * @throws Throwable
     */
    public function transform(PollOptionModelContract $item): array
    {
        return [
            'id' => $item['id'],
            'answer' => $item['answer'],
        ];
    }
}
