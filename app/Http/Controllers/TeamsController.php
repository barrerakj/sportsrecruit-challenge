<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\TeamsService;

class TeamsController extends Controller
{
    public function getTeams() {

        $teamsService = new TeamsService();
        $teams = $teamsService->getBalancedTeams();
        return view('teams', ['teams' => $teams]);
    }
}
