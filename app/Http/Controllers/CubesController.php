<?php

namespace App\Http\Controllers;

use App\Cube;
use Illuminate\Http\Request;

class CubesController extends Controller
{
    public function store($n)
    {
        $cube = Cube::created(['n' => $n]);
        $cube->generate();
        return $cube->matrix;
    }
}
