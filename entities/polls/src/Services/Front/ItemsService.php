<?php

namespace InetStudio\PollsPackage\Polls\Services\Front;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\Builder;
use InetStudio\AdminPanel\Base\Services\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract;
use InetStudio\PollsPackage\Polls\Contracts\Services\Front\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * ItemsService constructor.
     *
     * @param  PollModelContract  $model
     */
    public function __construct(PollModelContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Голосуем в опросе.
     *
     * @param  int  $pollID
     * @param  int  $optionID
     *
     * @return PollModelContract|null
     *
     * @throws BindingResolutionException
     */
    public function vote(int $pollID, int $optionID): ?PollModelContract
    {
        $pollsVotesService = app()->make('InetStudio\PollsPackage\Votes\Contracts\Services\Front\ItemsServiceContract');

        $item = $this->getItemById($pollID);

        if (! $item->id) {
            return null;
        }

        if (! $item->options->contains('id', $optionID)) {
            return null;
        }

        $result = $this->isVote($pollID);

        if (! $result['vote']) {
            $pollsVotesService->save(
                [
                    'user_id' => $result['userID'],
                    'option_id' => $optionID,
                ],
                0
            );

            Cookie::queue('poll_vote_'.$pollID, '1', 14400);
        }

        return $item;
    }

    /**
     * Участвовал пользователь в опросе или нет.
     *
     * @param  int  $pollID
     *
     * @return array
     *
     * @throws BindingResolutionException
     */
    public function isVote(int $pollID): array
    {
        $usersService = app()->make('InetStudio\ACL\Users\Contracts\Services\Front\UsersServiceContract');
        $userID = $usersService->getUserId();

        $voteCookie = (bool) request()->cookie('poll_vote_'.$pollID, null);

        $userVote = $this->model::whereHas(
                'options',
                function (Builder $optionsQuery) use ($userID) {
                    $optionsQuery->whereHas(
                        'votes',
                        function (Builder $votesQuery) use ($userID) {
                            $votesQuery->where('user_id', '=', $userID);
                        }
                    );
                }
            )
            ->where('id', $pollID)
            ->first();

        $vote = ($userID > 0 && ! $voteCookie) ? ((bool) $userVote) : $voteCookie;

        return [
            'userID' => $userID,
            'vote' => $vote,
        ];
    }
}
