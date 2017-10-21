<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $guarded = [];

    public function updateMatrix($matrix)
    {
        list($x, $y, $z, $value) = explode(' ', $this->operation);
        $matrix[$x][$y][$z] = intval($value);
        return $matrix;
    }
}
