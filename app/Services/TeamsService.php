<?php

namespace App\Services;

use App\Models\User;

class TeamsService
{
    public $players;
    public $goalies;
    public $playersCount;
    public $goaliesCount;
    
    function __construct()
    {
        $this->players = User::ofPlayers()->orderBy('ranking', 'desc')->get();
        $this->goalies = User::ofGoalies()->orderBy('ranking', 'desc')->get();
        $this->playersCount = User::ofPlayers()->count();
        $this->goaliesCount = User::ofGoalies()->count();
    }

    public function getNumberOfTeams(): int
    {
        $numberOfTeams = 0;
        for ($i=$this->goaliesCount; $i > 0; $i--) { 
            if(intdiv($this->playersCount, $i) >= 18){
                $numberOfTeams = $i;
                break;
            }
        }
        if($numberOfTeams % 2 == 1) $numberOfTeams--;

        return $numberOfTeams;
    }

    public function getBalancedTeams(): array
    {
        $teams = [];
        $numberOfTeams = $this->getNumberOfTeams();

        for ($i=0; $i < $numberOfTeams; $i++) { 
            array_push($teams, ["name" => fake()->name(), "players" => collect()]);
        }

        $allPlayers = $this->goalies->merge($this->players);

        for ($i=0; $i < $numberOfTeams; $i++) { 
            $teams[$i]["players"]->push($allPlayers->shift());
        }

        $allPlayers = $allPlayers->sortByDesc('ranking');

        foreach ($allPlayers as $player) {
            $lowestRankedTeam = $teams[0];
            foreach ($teams as $team) {
                if($team["players"]->sum('ranking') < $lowestRankedTeam["players"]->sum('ranking'))
                {
                    $lowestRankedTeam = $team;
                }
            }
            if($lowestRankedTeam["players"]->count() < 22){
                $lowestRankedTeam["players"]->push($player);
            }
        }

        return $teams;
    }
}