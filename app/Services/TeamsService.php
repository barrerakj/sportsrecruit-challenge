<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

class TeamsService
{
    /**
     * Get number of teams
     *
     * @param int $goaliesCount
     * @param int $playersCount
     * @return int
     */
    public function getNumberOfTeams(int $goaliesCount, int $playersCount): int
    {
        $numberOfTeams = 0;
        for ($i=$goaliesCount; $i > 0; $i--) { 
            if(intdiv($playersCount, $i) >= 18){
                $numberOfTeams = $i;
                break;
            }
        }
        if($numberOfTeams % 2 == 1) $numberOfTeams--;

        return $numberOfTeams;
    }

    /**
     * Get balanced teams
     *
     * @param int
     * @param \Illuminate\Database\Eloquent\Collection $goalies
     * @param \Illuminate\Database\Eloquent\Collection $players
     * @return array
     */
    public function getBalancedTeams(int $numberOfTeams, Collection $goalies, Collection $players): array
    {   
        $teams = [];

        for ($i=0; $i < $numberOfTeams; $i++) { 
            array_push($teams, ["name" => fake()->name(), "players" => collect()]);
        }

        $allPlayers = $goalies->merge($players);

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