<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class User extends Model
{
    public $timestamps = false;

    public $fillable = [
        'first_name',
        'last_name',
        'ranking',
    ];

    /**
     * Players only local scope
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfPlayers($query): Builder
    {
        return $query->where('user_type', 'player');
    }

    /**
     * Goalies only local scope
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfGoalies($query): Builder
    {
        return $query->where('can_play_goalie', 1);
    }

    /**
     * Is goalie
     *
     * @return bool
     */
    public function getIsGoalieAttribute(): bool
    {
        return (bool) $this->can_play_goalie;
    }

    /**
     * First name and lastname concatenated
     *
     * @return string
     */
    public function getFullnameAttribute(): string
    {
        return Str::title($this->first_name . ' ' . $this->last_name);
    }
}
