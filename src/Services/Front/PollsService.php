<?php

namespace InetStudio\Polls\Services\Front;

use Illuminate\Http\Request;
use InetStudio\Polls\Models\PollModel;
use InetStudio\Polls\Models\PollVoteModel;

class PollsService
{
    /**
     * Получаем опрос.
     *
     * @param int $id
     * @return PollModel
     */
    public function getPollById(int $id): PollModel
    {
        $cacheKey = 'PollsService_getPollById_'.md5($id);

        return \Cache::tags(['polls'])->remember($cacheKey, 1440, function() use ($id) {
            $items = PollModel::select(['id', 'question'])
                ->with(['options' => function ($query) {
                    $query->select(['id', 'answer', 'poll_id']);
                }])
                ->whereId($id)
                ->get();

            if ($items->count() == 0) {
                return null;
            }

            return $items->first();
        });
    }

    /**
     * Возвращаем данные для виджета.
     *
     * @param Request $request
     * @param PollModel $item
     * @return array
     */
    public function getWidgetData(Request $request,
                                  PollModel $item): array
    {
        $vote = $this->isVote($request, $item->id);

        $data = [
            'poll' => $this->getPollById($item->id),
            'vote' => $vote['vote'],
        ];

        return $data;
    }

    /**
     * Участвовал пользователь в опросе или нет.
     *
     * @param Request $request
     * @param int $pollID
     * @return array
     */
    public function isVote(Request $request,
                           int $pollID): array
    {
        $usersService = app()->make('UsersService');
        $userID = $usersService->getUserId();

        $voteCookie = $request->cookie('poll_vote_'.$pollID);

        if ($voteCookie) {
            return [
                'userID' => $userID,
                'vote' => true,
            ];
        }

        if ($userID > 0) {
            $poll = PollModel::whereHas('options', function ($optionsQuery) use ($userID) {
                    $optionsQuery->whereHas('votes', function ($votesQuery) use ($userID) {
                        $votesQuery->where('user_id', $userID);
                    });
                })
                ->where('id', $pollID)
                ->get();

            if ($poll->count() > 0) {
                return [
                    'userID' => $userID,
                    'vote' => true,
                ];
            }
        }

        return [
            'userID' => $userID,
            'vote' => false,
        ];
    }

    /**
     * Голосуем в опросе.
     *
     * @param Request $request
     * @param int $id
     * @return PollModel|null
     */
    public function vote(Request $request,
                         int $id): ?PollModel
    {
        $poll = $this->getPollById($id);

        if (! $poll) {
            return null;
        }

        $optionID = (isset($request->get('result')[0]['value'])) ? $request->get('result')[0]['value'] : 0;

        if (! $poll->options->contains('id', $optionID)) {
            return null;
        }

        $vote = $this->isVote($request, $id);

        if (! $vote['vote']) {
            PollVoteModel::create([
                'user_id' => $vote['userID'],
                'option_id' => $optionID,
            ]);

            \Cookie::queue('poll_vote_'.$id, '1', 14400);
        }

        return $poll;
    }
}
