<?php

use Faker\Generator as Faker;
use App\HojaRutaInterna as Model;

$factory->define(Model::class,
    function (Faker $faker) {
    return [
        'gestion' => date('Y'),
        'fecha' => date('Y-m-d'),
        'tipo_tarea' => 'EDC',
        'tipo' => 'interna',
        'numero' => Model::where('gestion', date('Y'))->max('numero') + 1,
    ];
});

$factory->state(Model::class, 'solicitud',
    function (Faker $faker) {
    return [
        'tipo' => 'solicitud',
    ];
});
