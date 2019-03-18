<?php

namespace InetStudio\PollsPackage\Analytics\Transformers\Back\Result;

use League\Fractal\TransformerAbstract;
use InetStudio\PollsPackage\Options\Contracts\Models\PollOptionModelContract;
use InetStudio\PollsPackage\Analytics\Contracts\Transformers\Back\Result\PollOptionTransformerContract;

/**
 * Class PollOptionTransformer.
 */
class PollOptionTransformer extends TransformerAbstract implements PollOptionTransformerContract
{
    protected $totalVotes;

    /**
     * PollOptionTransformer constructor.
     *
     * @param int $totalVotes
     */
    public function __construct(int $totalVotes)
    {
        $this->totalVotes = $totalVotes;
    }

    /**
     * Подготовка данных.
     *
     * @param PollOptionModelContract $item
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function transform(PollOptionModelContract $item): array
    {
        return [
            'id' => $item['id'],
            'answer' => $item['answer'],
            'votes' => $item['votes_count'],
            'votes_percent' => ($this->totalVotes == 0) ? 0 : round(($item['votes_count'] / $this->totalVotes)*100),
        ];
    }
}
