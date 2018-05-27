<?php

namespace InetStudio\Polls\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\Polls\Contracts\Models\PollModelContract;

/**
 * Class PollModel.
 */
class PollModel extends Model implements PollModelContract
{
    use SoftDeletes;

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'polls';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'question',
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

    protected $casts = [
        'single' => 'boolean',
        'closed' => 'boolean',
    ];

    /**
     * Отношение "один ко многим" с моделью ответов.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(app()->make('InetStudio\Polls\Contracts\Models\PollOptionModelContract'), 'poll_id');
    }

    /**
     * Получаем проголосовавших.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function voters()
    {
        return $this->options->voters;
    }
}
