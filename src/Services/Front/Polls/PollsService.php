<?php

namespace InetStudio\Polls\Services\Front\Polls;

use Illuminate\Http\Request;
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
    private $repository;

    /**
     * PollsService constructor.
     *
     * @param PollsRepositoryContract $repository
     */
    public function __construct(PollsRepositoryContract $repository)
    {
        $this->repository = $repository;
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
        $item = $this->repository->getItemsByIDs($id, false, [], ['options'])->first();

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

        $vote = ($userID > 0 && ! $voteCookie) ? $this->repository->checkUserVote($pollID, $userID) : $voteCookie;

        return [
            'userID' => $userID,
            'vote' => $vote,
        ];
    }

    /**
     * Голосуем в опросе.
     *
     * @param Request $request
     * @param int $id
     *
     * @return PollModelContract|null
     */
    public function vote(Request $request,
                         int $id): ?PollModelContract
    {
        $poll = $this->getPollById($id);

        if (! $poll) {
            return null;
        }

        $optionID = $request->get('result')[0]['value'] ?? 0;

        if (! $poll->options->contains('id', $optionID)) {
            return null;
        }

        $vote = $this->isVote($request, $id);

        if (! $vote['vote']) {
            PollVoteModel::create([
                'user_id' => $vote['userID'],
                'option_id' => $optionID,
            ]);

            Cookie::queue('poll_vote_'.$id, '1', 14400);
        }

        return $poll;
    }
}
