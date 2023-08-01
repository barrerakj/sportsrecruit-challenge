<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\TeamsService;

class PlayersIntegrityTest extends TestCase
{
    private $teamsService;

    protected function setUp(): void
    {
        $this->teamsService = new TeamsService();
    }

    public function testGetNumberOfTeams()
    {
        // Mock the players count and goalies count
        $this->teamsService->playersCount = 85;
        $this->teamsService->goaliesCount = 6;

        // Call the method and check the result
        $result = $this->teamsService->getNumberOfTeams();
        $this->assertEquals(4, $result);
    }
}
