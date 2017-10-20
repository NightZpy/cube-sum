<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CubeTest extends TestCase
{
    use DatabaseMigrations;

    public function test_a_cube_consists_of_games()
    {
        $cube = create('App\Cube');
        $game  = create('App\Game', ['cube_id' => $cube->id]);
        $this->assertTrue($cube->games->contains($game));
    }
}