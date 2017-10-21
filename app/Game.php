<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use function PHPSTORM_META\type;

class Game extends Model
{
    protected $guarded = [];

    public function updateMatrix($matrix)
    {
        list($x, $y, $z, $value) = explode(' ', $this->operation);
        $matrix[$x][$y][$z] = intval($value);
        return $matrix;
    }

    public function queryMatrix($matrix)
    {
        list($fromX, $fromY, $fromZ, $toX, $toY, $toZ) = array_map(function($value) {
            return intval($value);
        }, explode(' ', $this->operation));
        return $this->queryBruteForce($matrix, $fromX, $fromY, $fromZ, $toX, $toY, $toZ);
    }

    private function queryBruteForce($matrix, $fromX, $fromY, $fromZ, $toX, $toY, $toZ)
    {
        $total = 0;
        for ($x = $fromX; $x < $toX; $x ++) {
            for ($y = $fromY; $y < $toY; $y++) {
                for ($z = $fromZ; $z < $toZ; $z++) {
                    if ($matrix[$x][$y][$z] > 0) {
                        $total += $matrix[$x][$y][$z];
                        print_r([$x, $y, $z, $matrix[$x][$y][$z], $total]);
                    } else {
                        print_r([$x, $y, $z]);
                    }
                }
            }
        }
        dd($total);
        return $total;
    }
}
