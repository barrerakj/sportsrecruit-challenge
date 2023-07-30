<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class TeamsController extends Controller
{
    public function getTeams() {
        //General information
        $players = User::ofPlayers()->orderBy('ranking', 'desc')->get();
        $goalies = User::ofGoalies()->orderBy('ranking', 'desc')->get();
        $playersCount = User::ofPlayers()->count();

        //Problem 1: Guess the number of teams
        $goaliesCount = User::ofGoalies()->count();
        $numberOfTeams = 0;
        for ($i=$goaliesCount; $i > 0; $i--) { 
            if(intdiv($playersCount, $i) >= 18){
                $numberOfTeams = $i;
                break;
            }
        }
        if($numberOfTeams % 2 == 1) $numberOfTeams--;

        //Problem 2: Solved evenly match teams
        $teams = [];
        for ($i=0; $i < $numberOfTeams; $i++) { 
            array_push($teams, ["name" => fake()->name(), "players" => collect()]);
        }

        $allPlayers = $goalies->merge($players);

        //Problem 3: Assign Goalies to teams
        for ($i=0; $i < $numberOfTeams; $i++) { 
            $teams[$i]["players"]->push($allPlayers->shift());
        }

        $allPlayers = $allPlayers->sortByDesc('ranking');

        //Problem 4: Assign Players to teams
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

        return view('teams', ['teams' => $teams]);
    }
}
