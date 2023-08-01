<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\TeamsService;
use App\Repositories\PlayerRepository;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class PlayersIntegrityTest extends TestCase
{
    private $teamsService;
    private $playersRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->teamsService = new TeamsService();
        $this->playersRepository = new PlayerRepository();
    }

    public function testGetNumberOfTeams()
    {
        // Test case 1: GoaliesCount and PlayersCount are both zero
        $this->assertEquals(0, $this->teamsService->getNumberOfTeams(0, 0));

        // Test case 2: GoaliesCount is zero, PlayersCount is 100
        $this->assertEquals(0, $this->teamsService->getNumberOfTeams(0, 100));

        // Test case 3: GoaliesCount is 6, PlayersCount is 85
        $this->assertEquals(4, $this->teamsService->getNumberOfTeams(6, 85));

    }

    public function testGetBalancedTeams()
    {
        // Create fake goalies and players using Laravel Collection
        // $goalies = new Collection();
        // for ($i=0; $i < 6; $i++) { 
        //     $goalies->push(new User(
        //         [
        //             'first_name'    => fake()->name(),
        //             'last_name'    => fake()->name(),
        //             'ranking'   => rand(1,5)
        //         ]
        //     ));
        // }

        // $players = new Collection();
        // for ($i=0; $i < 86; $i++) { 
        //     $players->push(new User(
        //         [
        //             'first_name'    => fake()->name(),
        //             'last_name'    => fake()->name(),
        //             'ranking'       => rand(1,5)
        //         ]
        //     ));
        // }

        $goalies = $this->playersRepository->getGoalies();
        $players = $this->playersRepository->getPlayers();

        // Test case 1: Check if the correct number of teams is returned
        $numberOfTeams = 4;
        $teams = $this->teamsService->getBalancedTeams($numberOfTeams, $goalies, $players);
        $this->assertCount($numberOfTeams, $teams);

        // Test case 2: Check if all teams have players
        foreach ($teams as $team) {
            $this->assertNotEmpty($team['players']);
            $this->assertThat(
                count($team['players']),
                $this->logicalAnd(
                    $this->greaterThan(17),
                    $this->lessThan(23)
                )
            );
        }
    }
}
