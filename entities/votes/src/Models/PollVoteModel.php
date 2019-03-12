<?php

namespace InetStudio\PollsPackage\Votes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;
use InetStudio\PollsPackage\Votes\Contracts\Models\PollVoteModelContract;

/**
 * Class PollVoteModel.
 */
class PollVoteModel extends Model implements PollVoteModelContract
{
    use SoftDeletes;
    use BuildQueryScopeTrait;

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'polls_votes';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'option_id',
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
            'id', 'user_id', 'option_id',
        ];
    }

    /**
     * Сеттер атрибута user_id.
     *
     * @param $value
     */
    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id'] = (int) trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута option_id.
     *
     * @param $value
     */
    public function setOptionIdAttribute($value)
    {
        $this->attributes['option_id'] = (int) trim(strip_tags($value));
    }

    /**
     * Обратное отношение "один ко многим" с моделью ответа.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function option()
    {
        return $this->belongsTo(
            app()->make('InetStudio\PollsPackage\Options\Contracts\Models\PollOptionModelContract'),
            'id',
            'option_id'
        );
    }
}
