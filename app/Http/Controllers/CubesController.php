<?php

namespace App\Http\Controllers;

use App\Cube;
use Illuminate\Http\Request;

class CubesController extends Controller
{
    public function store($n)
    {
        $cube = Cube::create(['n' => $n]);
        return $cube->matrix;
    }
}
