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
        $matrix[$x - 1][$y - 1][$z - 1] = intval($value);
        return $matrix;
    }

    public function queryMatrix($matrix)
    {
        list($fromX, $fromY, $fromZ, $toX, $toY, $toZ) = array_map(function($value) {
            return intval($value) - 1;
        }, explode(' ', $this->operation));
        return $this->queryBruteForce($matrix, $fromX, $fromY, $fromZ, $toX, $toY, $toZ);
    }

    private function queryBruteForce($matrix, $fromX, $fromY, $fromZ, $toX, $toY, $toZ)
    {
        // 0 1 1 2 2 2
        $n = count($matrix) - 1;
        //echo "N: $n---------------------------\n";
        $total = 0;
        //print_r([$fromX, $toX]);
        for ($x = $fromX; $x <= $toX; $x ++) {
            //echo "X: $x--------------------------\n";
            if ($x > $fromX)
            $fromY = 0;

            $untilY = $n;
            if ($x == $toX)
                $untilY = $toY;

            //echo "fromY: $fromY; untilY: $untilY------------------\n";
            for ($y = $fromY; $y <= $untilY; $y++) {
                //echo "Y: $y--------------------------\n";
                if ($y > $fromY)
                    $fromZ = 0;

                $untilZ = $n;
                if ($x == $toX && $y == $toY)
                    $untilZ = $toZ;

                //echo "fromZ: $fromZ; untilZ: $untilZ------------------\n";
                for ($z = $fromZ; $z <= $untilZ; $z++) {
                    //echo "Z: $z--------------------------\n";
                    if ($matrix[$x][$y][$z] > 0) {
                        $total += $matrix[$x][$y][$z];
                       //print_r([$x, $y, $z, $matrix[$x][$y][$z], $total]);
                    }
                }
            }
        }
        //dd($total);
        return $total;
    }
}
