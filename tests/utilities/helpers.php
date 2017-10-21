<?php

function create($class, $attributes = [], $quantity = 1)
{
    if ($quantity > 1)
        return factory ($class, $quantity)->create($attributes);
    return factory ($class)->create($attributes);
}

function make($class, $attributes = [])
{
    return factory ($class)->make($attributes);
}

function generateCube($n = 5) {
    $cube = [];
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
?>