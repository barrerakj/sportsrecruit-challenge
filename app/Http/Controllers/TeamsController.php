<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\TeamsService;
use App\Repositories\PlayerRepository;

class TeamsController extends Controller
{
    public function getTeams() {

        $playersRepository = new PlayerRepository();
        $teamsService = new TeamsService();

        $goaliesCount = $playersRepository->getGoaliesCount();
        $playersCount = $playersRepository->getPlayersCount();
        $goalies = $playersRepository->getGoalies();
        $players = $playersRepository->getPlayers();

        $numberOfTeams = $teamsService->getNumberOfTeams($goaliesCount, $playersCount);
        $teams = $teamsService->getBalancedTeams($numberOfTeams, $goalies, $players);
        return view('teams', ['teams' => $teams]);
    }
}
