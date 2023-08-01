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

    public function getPlayers(): Collection
    {
        return $this->model->ofPlayers()->orderBy('ranking', 'desc')->get();
    }

    public function getPlayersCount(): int
    {
        return $this->model->ofPlayers()->count();
    }

    public function getGoalies(): Collection
    {
        return $this->model->ofGoalies()->orderBy('ranking', 'desc')->get();
    }

    public function getGoaliesCount(): int
    {
        return $this->model->ofGoalies()->count();
    }
}