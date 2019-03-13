<?php

namespace InetStudio\PollsPackage\Polls\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\PollsPackage\Polls\Contracts\Models\PollModelContract;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;

/**
 * Class PollModel.
 */
class PollModel extends Model implements PollModelContract
{
    use SoftDeletes;
    use BuildQueryScopeTrait;

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
        'question', 'single', 'closed',
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
     * Загрузка модели.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::$buildQueryScopeDefaults['columns'] = [
            'id', 'question', 'single', 'closed',
        ];

        self::$buildQueryScopeDefaults['relations'] = [
            'options' => function ($optionsQuery) {
                $optionsQuery->select(['id', 'poll_id', 'answer'])->withCount('votes');
            },
        ];
    }

    /**
     * Сеттер атрибута question.
     *
     * @param $value
     */
    public function setQuestionAttribute($value)
    {
        $this->attributes['question'] = trim(str_replace("&nbsp;", ' ', strip_tags((isset($value['text'])) ? $value['text'] : (! is_array($value) ? $value : ''))));
    }

    /**
     * Сеттер атрибута single.
     *
     * @param $value
     */
    public function setSingleAttribute($value)
    {
        $value = $value[0] ?? (is_array($value) ? '' : $value);

        $this->attributes['single'] = (bool) trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута closed.
     *
     * @param $value
     */
    public function setClosedAttribute($value)
    {
        $value = $value[0] ?? (is_array($value) ? '' : $value);

        $this->attributes['closed'] = (bool) trim(strip_tags($value));
    }

    /**
     * Отношение "один ко многим" с моделью ответов.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(
            app()->make('InetStudio\PollsPackage\Options\Contracts\Models\PollOptionModelContract'),
            'poll_id'
        );
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