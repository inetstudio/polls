<?php

namespace InetStudio\Polls\Services\Front\Polls;

use Illuminate\Support\Facades\Cookie;
use InetStudio\Polls\Models\PollVoteModel;
use InetStudio\Polls\Contracts\Models\PollModelContract;
use InetStudio\Polls\Contracts\Repositories\PollsRepositoryContract;
use InetStudio\Polls\Contracts\Services\Front\Polls\PollsServiceContract;

/**
 * Class PollsService.
 */
class PollsService implements PollsServiceContract
{
    /**
     * @var PollsRepositoryContract
     */
    private $repositories;

    /**
     * PollsService constructor.
     */
    public function __construct()
    {
        $this->repositories['polls'] = app()->make('InetStudio\Polls\Contracts\Repositories\PollsRepositoryContract');
        $this->repositories['pollsVotes'] = app()->make('InetStudio\Polls\Contracts\Repositories\PollsVotesRepositoryContract');
    }

    /**
     * Получаем опрос.
     *
     * @param int $id
     *
     * @return PollModelContract|null
     */
    public function getPollById(int $id): ?PollModelContract
    {
        $item = $this->repositories['polls']->getItemsByIDs($id, false, [], ['options'])->first();

        return $item ?? null;
    }

    /**
     * Участвовал пользователь в опросе или нет.
     *
     * @param int $pollID
     *
     * @return array
     */
    public function isVote(int $pollID): array
    {
        $usersService = app()->make('UsersService');
        $userID = $usersService->getUserId();

        $voteCookie = (bool) request()->cookie('poll_vote_'.$pollID, false);

        $vote = ($userID > 0 && ! $voteCookie) ? $this->repositories['polls']->checkUserVote($pollID, $userID) : $voteCookie;

        return [
            'userID' => $userID,
            'vote' => $vote,
        ];
    }

    /**
     * Голосуем в опросе.
     *
     * @param int $pollID
     * @param int $optionID
     *
     * @return PollModelContract|null
     */
    public function vote(int $pollID, int $optionID): ?PollModelContract
    {
        $poll = $this->getPollById($pollID);

        if (! $poll->id) {
            return null;
        }

        if (! $poll->options->contains('id', $optionID)) {
            return null;
        }

        $result = $this->isVote($pollID);

        if (! $result['vote']) {
            $this->repositories['pollsVotes']->save([
                'user_id' => $result['userID'],
                'option_id' => $optionID,
            ]);

            Cookie::queue('poll_vote_'.$pollID, '1', 14400);
        }

        return $poll;
    }
}
