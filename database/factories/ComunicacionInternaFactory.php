<?php

use Faker\Generator as Faker;
use App\ComunicacionesInternas as Model;

$factory->define(
    Model::class,
    function (Faker $faker) {
        return [
            'gestion' => date('Y'),
        ];
    }
);
