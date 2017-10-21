<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExecuteCubeOperationsTest extends TestCase
{
    use DatabaseMigrations;

    public function test_a_user_can_make_a_valid_cube()
    {
        $n = 4;
        $cube = generateCube($n);
        $this->get('/make-cube/' . $n)
             ->assertJson($cube);
    }

    public function test_a_user_can_update_the_cube()
    {
        $cube = create('App\Cube', ['n' => 4]);
        $matrix = $cube->matrix;
        Session::put('matrix', $matrix);

        $matrix[0][1][1] = 10;
        $this->post('update', ['cube_id' => $cube->id, 'operation' => '0 1 1 10'])
             ->assertJson($matrix);

        $matrix[1][1][1] = 8;
        $this->post('update', ['cube_id' => $cube->id, 'operation' => '1 1 1 8'])
             ->assertJson($matrix);

        $matrix[2][1][1] = 6;
        $this->post('update', ['cube_id' => $cube->id, 'operation' => '2 1 1 6'])
             ->assertJson($matrix);

        $matrix[3][1][1] = 5;
        $this->post('update', ['cube_id' => $cube->id, 'operation' => '3 1 1 5'])
             ->assertJson($matrix);

    }
}