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
        $n = count($matrix) - 1;
        $total = 0;
        for ($x = $fromX; $x <= $toX; $x ++) {
            if ($x > $fromX)
            $fromY = 0;

            $untilY = $n;
            if ($x == $toX)
                $untilY = $toY;

            for ($y = $fromY; $y <= $untilY; $y++) {
                if ($y > $fromY)
                    $fromZ = 0;

                $untilZ = $n;
                if ($x == $toX && $y == $toY)
                    $untilZ = $toZ;

                for ($z = $fromZ; $z <= $untilZ; $z++) {
                    if ($matrix[$x][$y][$z] > 0) {
                        $total += $matrix[$x][$y][$z];
                    }
                }
            }
        }
        return $total;
    }
}
