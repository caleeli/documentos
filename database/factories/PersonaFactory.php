<?php

use Faker\Generator as Faker;
use App\Persona as Model;

$factory->define(Model::class,
    function (Faker $faker) {
    return [
        'per_nombres' => '',
        'per_apellidos' => '',
        'per_ci_nit' => '',
        'per_tipo_persona' => 'natural'
    ];
});
