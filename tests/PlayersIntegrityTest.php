<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\User;

class PlayersIntegrityTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGoaliePlayersExist () 
    {
/*
		Check there are players that have can_play_goalie set as 1   
*/
		$result = User::where('user_type', 'player')->where('can_play_goalie', 1)->count();
		$this->assertTrue($result > 1);
	
    }
    public function testAtLeastOneGoaliePlayerPerTeam ()
    {
/*
	    calculate how many teams can be made so that there is an even number of teams and they each have between 18-22 players.
	    Then check that there are at least as many players who can play goalie as there are teams
*/         
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

        //Problem 2: Solved evenly match teams
        $teams = [];
        for ($i=0; $i < $numberOfTeams; $i++) { 
            array_push($teams, collect());
        }

        $allPlayers = $goalies->merge($players);

        //Problem 3: Assign Goalies to teams
        for ($i=0; $i < $numberOfTeams; $i++) { 
            $teams[$i]->push($allPlayers->shift());
        }

        $allPlayers = $allPlayers->sortByDesc('ranking');

        //Problem 4: Assign Players to teams
        foreach ($allPlayers as $player) {
            $lowestRankedTeam = $teams[0];
            foreach ($teams as $team) {
                if($team->sum('ranking') < $lowestRankedTeam->sum('ranking'))
                {
                    $lowestRankedTeam = $team;
                }
            }
            if($lowestRankedTeam->count() < 23){
                $lowestRankedTeam->push($player);
            }
        }
    }
}
