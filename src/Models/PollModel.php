<?php

namespace InetStudio\Polls\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PollModel extends Model
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
     * A poll has many options.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(PollOptionModel::class, 'poll_id');
    }

    /**
     * Get the voters who voted to that option.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function voters()
    {
        return $this->options->voters;
    }

    /**
     * Количество вариантов ответа в опросе.
     *
     * @return mixed
     */
    public function optionsNumber()
    {
        return $this->options()->count();
    }

    /**
     * @return bool
     */
    public function isRadio()
    {
        return $this->single;
    }

    /**
     * Check if it accepts many options.
     *
     * @return bool
     */
    public function isCheckable()
    {
        return ! $this->isRadio();
    }

    /**
     * Check if the poll is closed.
     *
     * @return bool
     */
    public function isLocked()
    {
        return $this->closed == true;
    }

    public static function getOptionClassName(): string
    {
        return PollOptionModel::class;
    }

    /**
     * @param array|\ArrayAccess|\InetStudio\Polls\Models\PollOptionModel $options
     *
     * @return $this
     */
    public function attachOptions($options)
    {
        $className = static::getOptionClassName();

        $className::findOrCreate($options, $this->id);

        return $this;
    }

    /**
     * @param string|\InetStudio\Polls\Models\PollOptionModel $option
     *
     * @return $this
     */
    public function attachOption($option)
    {
        return $this->attachOptions([$option]);
    }

    /**
     * @param array|\ArrayAccess $options
     *
     * @return $this
     */
    /*
    public function detachOptions($options)
    {
        $options = collect($options);



        return $this;
    }
    */

    public function detachOptionsExcept($options)
    {
        $excludedOptions = collect($options);

        if ($excludedOptions->isEmpty()) {
            return $this;
        }

        $this->options
            ->reject(function (PollOptionModel $option) use ($excludedOptions) {
                return $excludedOptions->where('id', $option->id)->count();
            })
            ->each->delete();

        return $this;
    }

    /*
     * @param string|\InetStudio\Polls\Models\PollOptionModel $option
     *
     * @return $this
     */
    /*
    public function detachOption($option)
    {
        return $this->detachOptions([$option]);
    }
    */

    /*
     * Close the poll
     *
     * @return mixed
     */
    /*
    public function lock()
    {
        foreach ($this->options()->get() as $option) {
            $option->updateTotalVotes();
        }
        $this->isClosed = 1;
        return $this->save();
    }
    */

    //protected $results = null;

    /*
     * Get Poll results
     *
     * @return array
     */
    /*
    public function results()
    {
        $this->results = collect();
        foreach ($this->options()->get() as $option) {
            $this->results->push([
                "option" => $option,
                "votes" => $option->countVotes(),
            ]);
        }

        return $this;
    }
    */

    /*
     * Get the result in order
     *
     * @return mixed
     */
    /*
    public function inOrder()
    {
        if (!is_null($this->results)) {
            $new = $this->results->sortByDesc('votes');
            return $new->toArray();
        }
    }
    */

    /*
     * Get results in poll order
     *
     * @return mixed
     */
    /*
    public function grab()
    {
        if (!is_null($this->results)) {
            return $this->results->toArray();
        }
    }
    */
}
