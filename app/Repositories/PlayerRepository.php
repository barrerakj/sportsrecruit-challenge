<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class PlayerRepository
{
    private $model;
    
    function __construct()
    {
        $this->model = new User();
    }

    /**
     * Players List
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPlayers(): Collection
    {
        return $this->model->ofPlayers()->orderBy('ranking', 'desc')->get();
    }

    /**
     * Players Count
     *
     * @return int
     */
    public function getPlayersCount(): int
    {
        return $this->model->ofPlayers()->count();
    }

    /**
     * Goalies List
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getGoalies(): Collection
    {
        return $this->model->ofGoalies()->orderBy('ranking', 'desc')->get();
    }

    /**
     * Goalies Count
     *
     * @return int
     */
    public function getGoaliesCount(): int
    {
        return $this->model->ofGoalies()->count();
    }
}