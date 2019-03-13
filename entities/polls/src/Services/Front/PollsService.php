<?php

namespace InetStudio\PollsPackage\Polls\Services\Front;

use Illuminate\Support\Facades\Cookie;
use InetStudio\AdminPanel\Base\Services\Front\BaseService;
use InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract;
use InetStudio\PollsPackage\Polls\Contracts\Services\Front\PollsServiceContract;

/**
 * Class PollsService.
 */
class PollsService extends BaseService implements PollsServiceContract
{
    /**
     * PollsService constructor.
     */
    public function __construct()
    {
        parent::__construct(app()->make('InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract'));
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
        $pollsVotesService = app()->make('InetStudio\PollsPackage\Votes\Contracts\Services\Front\PollsVotesServiceContract');

        $item = $this->getItemById($pollID);

        if (! $item->id) {
            return null;
        }

        if (! $item->options->contains('id', $optionID)) {
            return null;
        }

        $result = $this->isVote($pollID);

        if (! $result['vote']) {
            $pollsVotesService->save([
                'user_id' => $result['userID'],
                'option_id' => $optionID,
            ], 0);

            Cookie::queue('poll_vote_'.$pollID, '1', 14400);
        }

        return $item;
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
        $usersService = app()->make('InetStudio\ACL\Users\Contracts\Services\Front\UsersServiceContract');
        $userID = $usersService->getUserId();

        $voteCookie = (bool) request()->cookie('poll_vote_'.$pollID, false);

        $userVote = $this->model::whereHas('options', function ($optionsQuery) use ($userID) {
                $optionsQuery->whereHas('votes', function ($votesQuery) use ($userID) {
                    $votesQuery->where('user_id', $userID);
                });
            })
            ->where('id', $pollID)
            ->first();

        $vote = ($userID > 0 && ! $voteCookie) ? (!! $userVote) : $voteCookie;

        return [
            'userID' => $userID,
            'vote' => $vote,
        ];
    }
}
