<?php

namespace App\Http\Controllers;

use App\Cube;
use App\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CubesController extends Controller
{
    public function store($n)
    {
        if ( Session::has('matrix'))
            return Session::get('matrix');

        $cube = Cube::create(['n' => $n]);
        $matrix = $cube->matrix;
        Session::put('matrix', $matrix);
        return $matrix;
    }

    public function updateCmd()
    {
        $operation = request()->get('operation');
        $cubeId = request()->get('cube_id');
        $game = Game::create(['type' => 'update', 'operation' => $operation, 'cube_id' => $cubeId]);
        $matrix = Session::get('matrix');
        $matrix = $game->updateMatrix($matrix);
        Session::put('matrix', $matrix);
        return $matrix;
    }

    public function queryCmd()
    {
        $operation = request()->get('operation');
        $cubeId = request()->get('cube_id');
        $game = Game::create(['type' => 'query', 'operation' => $operation, 'cube_id' => $cubeId]);
        $matrix = Session::get('matrix');
        return ['total' => $game->queryMatrix($matrix)];
    }
}
