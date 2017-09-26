<?php

namespace InetStudio\Polls\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PollOptionModel extends Model
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
     * An option belongs to one poll.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function poll()
    {
        return $this->belongsTo(PollModel::class);
    }

    public function votes()
    {
        return $this->hasMany(PollVoteModel::class, 'option_id', 'id');
    }

    /**
     * Get the voters who voted to that option.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function voters()
    {
        return $this->belongsToMany(\App\User::class, 'polls_votes')->withTimestamps();
    }

    /**
     * Check if the option is voted.
     *
     * @return bool
     */
    public function isVoted()
    {
        return $this->voters()->count() != 0;
    }

    public static function findOrCreate($values, $pollID = 0)
    {
        $options = collect($values)->map(function ($value) use ($pollID) {
            if ($value instanceof PollOptionModel) {
                return $value;
            }

            return static::findOrCreateFromArray($value, $pollID);
        });

        return is_string($values) ? $options->first() : $options;
    }

    public static function findFromArray($value, $pollID)
    {
        return static::query()
            ->where('id', $value['id'])
            ->where('poll_id', $pollID)
            ->first();
    }

    protected static function findOrCreateFromArray($value, $pollID)
    {
        $option = static::findFromArray($value, $pollID);

        if (! $option) {
            $option = static::create(array_merge($value, [
                'poll_id' => $pollID,
            ]));
        }

        return $option;
    }
}
