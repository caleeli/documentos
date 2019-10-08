<?php

use Faker\Generator as Faker;
use App\Persona as Model;

$factory->define(
    Model::class,
    function (Faker $faker) {
        return [
            'per_nombres' => $faker->firstName(),
            'per_apellidos' => $faker->lastName(),
            'per_ci_nit' => $faker->numberBetween(4900000, 5900000),
            'per_tipo_persona' => $faker->randomElement(['natural', 'juridica']),
        ];
    }
);
