<?php

namespace InetStudio\PollsPackage\Options\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
        'poll_id', 'answer',
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
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::$buildQueryScopeDefaults['columns'] = [
            'id', 'poll_id', 'answer',
        ];
    }

    /**
     * Сеттер атрибута poll_id.
     *
     * @param $value
     */
    public function setPollIdAttribute($value)
    {
        $this->attributes['poll_id'] = (int) trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута answer.
     *
     * @param $value
     */
    public function setAnswerAttribute($value)
    {
        $this->attributes['answer'] = trim(str_replace("&nbsp;", ' ', strip_tags((isset($value['text'])) ? $value['text'] : (! is_array($value) ? $value : ''))));
    }

    /**
     * Обратное отношение "один ко многим" с моделью опроса.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function poll()
    {
        return $this->belongsTo(
            app()->make('InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract')
        );
    }

    /**
     * Отношение "один ко многим" с моделью голосов.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes()
    {
        return $this->hasMany(
            app()->make('InetStudio\PollsPackage\Votes\Contracts\Models\PollVoteModelContract'),
            'option_id',
            'id'
        );
    }

    /**
     * Получаем проголосовавших за этот ответ.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function voters()
    {
        return $this->belongsToMany(
            app()->make('InetStudio\ACL\Users\Contracts\Models\UserModelContract'),
            'polls_votes'
        )->withTimestamps();
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
