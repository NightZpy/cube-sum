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
        $response = $this->post('/make-cube', ['n' => $n])->json();
             $this->assertEquals($cube, $response['matrix']);
    }

    public function test_a_user_can_update_the_cube()
    {
        $cube = create('App\Cube', ['n' => 4]);
        $matrix = $cube->matrix;
        Session::put('matrix', $matrix);

        $matrix[0][1][1] = 10;
        $this->post('update', ['cube_id' => $cube->id, 'operation' => '1 2 2 10'])
             ->assertJson($matrix);

        $matrix[1][1][1] = 8;
        $this->post('update', ['cube_id' => $cube->id, 'operation' => '2 2 2 8'])
             ->assertJson($matrix);

        $matrix[2][1][1] = 6;
        $this->post('update', ['cube_id' => $cube->id, 'operation' => '3 2 2 6'])
             ->assertJson($matrix);

        $matrix[3][1][1] = 5;
        $this->post('update', ['cube_id' => $cube->id, 'operation' => '4 2 2 5'])
             ->assertJson($matrix);

    }

    public function test_a_user_can_query_to_the_cube()
    {
        $cube = create('App\Cube', ['n' => 4]);
        $matrix = $cube->matrix;
        Session::put('matrix', $matrix);

        $this->post('update', ['cube_id' => $cube->id, 'operation' => '2 2 2 4']);
        $response = $this->post('query', ['cube_id'=> $cube->id, 'operation' => '1 1 1 3 3 3'])->json();
        $this->assertEquals(4, intval($response['total']));

        $this->post('update', ['cube_id' => $cube->id, 'operation' => '1 1 1 23']);
        $response = $this->post('query', ['cube_id'=> $cube->id, 'operation' => '2 2 2 4 4 4'])->json();
        $this->assertEquals(4, intval($response['total']));

        $response = $this->post('query', ['cube_id'=> $cube->id, 'operation' => '1 1 1 3 3 3'])->json();
        $this->assertEquals(27, intval($response['total']));
    }
}