<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Cube::class, function (Faker\Generator $faker) {
    return [
      'n' => $faker->numberBetween(2, 4)
    ];
});

$factory->define(App\Game::class, function (Faker\Generator $faker) {
    $type = $faker->randomElement(['QUERY', 'UPDATE']);
    $cube = factory ('App\Cube')->create();
    $n = $cube->n;
    if ($type == 'UPDATE') {
        $values = [];
        for ($i=0; $i < 4; $i++) {
            $values[] = $faker->unique()->numberBetween(0, $n);
        }
        $operation = join(' ', $values);
    } else {
        $values = [];
        for ($i=0; $i < 6; $i++) {
            $values[] = $faker->unique()->numberBetween(0, $n);
        }
        $operation = join(' ', $values);
    }
    return [
        'type' => $type,
        'operation' => $operation,
        'cube_id' => $cube->id
    ];
});
