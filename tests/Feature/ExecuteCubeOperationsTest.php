<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExecuteCubeOperationsTest extends TestCase
{
    use DatabaseMigrations;

    public function test_a_user_can_make_a_valid_cube()
    {
        $n = 5;
        $cube = [];
        for ($x = 0; $x < $n; $x ++) {
            $cube[$x] = [];
            for ($y = 0; $y < $n; $y ++) {
                $cube[$x][$y] = [];
                for ($z = 0; $z < $n; $z ++)
                    $cube[$x][$y][$z] = 0;
            }
        }

        $this->get('/make-cube/' . $n)
             ->assertJson($cube);
    }
}