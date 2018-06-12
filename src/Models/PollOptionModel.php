<?php

namespace InetStudio\Polls\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\Polls\Contracts\Models\PollOptionModelContract;

/**
 * Class PollOptionModel.
 */
class PollOptionModel extends Model implements PollOptionModelContract
{
    use SoftDeletes;

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
        'answer', 'poll_id',
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
     * Обратное отношение "один ко многим" с моделью опроса.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function poll()
    {
        return $this->belongsTo(app()->make('InetStudio\Polls\Contracts\Models\PollModelContract'));
    }

    /**
     * Отношение "один ко многим" с моделью голосов.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes()
    {
        return $this->hasMany(app()->make('InetStudio\Polls\Contracts\Models\PollVoteModelContract'), 'option_id', 'id');
    }

    /**
     * Получаем проголосовавших за этот ответ.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function voters()
    {
        return $this->belongsToMany(app()->make('InetStudio\ACL\Users\Contracts\Models\UserModelContract'), 'polls_votes')->withTimestamps();
    }

    /**
     * Проверяем, что за этот ответ голосовали.
     *
     * @return bool
     */
    public function isVoted()
    {
        return $this->voters()->count() != 0;
    }
}
