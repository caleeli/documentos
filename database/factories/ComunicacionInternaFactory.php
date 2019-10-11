<?php

use Faker\Generator as Faker;
use App\ComunicacionesInternas as Model;

$factory->define(
    Model::class,
    function (Faker $faker) {
        return [
        ];
    }
);

$factory->state(
    Model::class,
    'create',
    function (Faker $faker) {
        return [
            'gestion' => date('Y'),
            'fecha_emision' => date('Y-m-d'),
            'fecha_entrega' => date('Y-m-d'),
            'fecha_recepcion' => date('Y-m-d'),
        ];
    }
);
