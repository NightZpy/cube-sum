<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cube extends Model
{
    protected $guarded = [];

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function getMatrixAttribute()
    {
        return $this->generateMatrix();
    }

    protected function generateMatrix()
    {
        $cube = [];
        $n = $this->n;
        for ($x = 0; $x < $n; $x ++) {
            $cube[$x] = [];
            for ($y = 0; $y < $n; $y ++) {
                $cube[$x][$y] = [];
                for ($z = 0; $z < $n; $z ++)
                    $cube[$x][$y][$z] = 0;
            }
        }
        return $cube;
    }
}
