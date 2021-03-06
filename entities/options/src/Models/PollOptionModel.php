<?php

namespace InetStudio\PollsPackage\Options\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;
use InetStudio\PollsPackage\Options\Contracts\Models\PollOptionModelContract;

/**
 * Class PollOptionModel.
 */
class PollOptionModel extends Model implements PollOptionModelContract
{
    use SoftDeletes;
    use BuildQueryScopeTrait;

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'polls_options';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'poll_id',
        'answer',
    ];

    /**
     * Атрибуты, которые должны быть преобразованы в даты.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Загрузка модели.
     */
    protected static function boot()
    {
        parent::boot();

        self::$buildQueryScopeDefaults['columns'] = [
            'id',
            'poll_id',
            'answer',
        ];

        self::$buildQueryScopeDefaults['relations'] = [
            'voters' => function (BelongsToMany $votersQuery) {
                $votersQuery->select(['id', 'name', 'email']);
            },

            'votes' => function (HasMany $votesQuery) {
                $votesQuery->select(['id', 'user_id', 'option_id']);
            },

            'poll' => function (BelongsTo $pollQuery) {
                $pollQuery->select(['id', 'question', 'single', 'closed']);
            },
        ];
    }

    /**
     * Сеттер атрибута poll_id.
     *
     * @param $value
     */
    public function setPollIdAttribute($value): void
    {
        $this->attributes['poll_id'] = (int) trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута answer.
     *
     * @param $value
     */
    public function setAnswerAttribute($value): void
    {
        $value = (isset($value['text'])) ? $value['text'] : (! is_array($value) ? $value : '');

        $this->attributes['answer'] = trim(str_replace('&nbsp;', ' ', strip_tags($value)));
    }

    /**
     * Обратное отношение "один ко многим" с моделью опроса.
     *
     * @return BelongsTo
     *
     * @throws BindingResolutionException
     */
    public function poll(): BelongsTo
    {
        $pollModel = app()->make('InetStudio\PollsPackage\Votes\Contracts\Models\PollVoteModelContract');

        return $this->belongsTo(
            get_class($pollModel)
        );
    }

    /**
     * Отношение "один ко многим" с моделью голосов.
     *
     * @return HasMany
     *
     * @throws BindingResolutionException
     */
    public function votes(): HasMany
    {
        $voteModel = app()->make('InetStudio\PollsPackage\Votes\Contracts\Models\PollVoteModelContract');

        return $this->hasMany(
            get_class($voteModel),
            'option_id',
            'id'
        );
    }

    /**
     * Получаем проголосовавших за этот ответ.
     *
     * @return BelongsToMany
     *
     * @throws BindingResolutionException
     */
    public function voters(): BelongsToMany
    {
        $userModel = app()->make('InetStudio\ACL\Users\Contracts\Models\UserModelContract');

        return $this->belongsToMany(
            get_class($userModel),
            'polls_votes'
        )->withTimestamps();
    }

    /**
     * Проверяем, что за этот ответ голосовали.
     *
     * @return bool
     *
     * @throws BindingResolutionException
     */
    public function isVoted(): bool
    {
        return $this->voters()->count() != 0;
    }
}
