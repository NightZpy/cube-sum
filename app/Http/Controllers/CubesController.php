<?php

namespace App\Http\Controllers;

use App\Cube;
use App\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CubesController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'n' => 'required|digits_between: 1,100',
        ]);

        //if ( Session::has('matrix'))
        //    return Session::get('matrix');

        $cube = Cube::create(['n' => $request->get('n')]);
        $matrix = $cube->matrix;
        Session::put('matrix', $matrix);
        return ['matrix' => $matrix, 'success' => true];
    }

    public function updateCmd(Request $request)
    {
        $this->validate($request, [
            'operation' => 'required|regex:/^\d( ?\d){3}$/',
            'cube_id' => 'required|exists:cubes,id'
        ]);
        $operation = request()->get('operation');
        $cubeId = request()->get('cube_id');
        $game = Game::create(['type' => 'update', 'operation' => $operation, 'cube_id' => $cubeId]);
        $matrix = Session::get('matrix');
        $matrix = $game->updateMatrix($matrix);
        Session::put('matrix', $matrix);
        return $matrix;
    }

    public function queryCmd(Request $request)
    {
        $this->validate($request, [
            'operation' => 'required|regex:/^\d( ?\d){5}$/',
            'cube_id' => 'required|exists:cubes,id'
        ]);
        $operation = request()->get('operation');
        $cubeId = request()->get('cube_id');
        $game = Game::create(['type' => 'query', 'operation' => $operation, 'cube_id' => $cubeId]);
        $matrix = Session::get('matrix');
        return ['total' => $game->queryMatrix($matrix)];
    }
}
