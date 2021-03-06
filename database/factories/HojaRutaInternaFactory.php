<?php

use Faker\Generator as Faker;
use App\HojaRutaSolicitud as Model;

$factory->define(Model::class,
    function (Faker $faker) {
    return [
        'gestion' => date('Y'),
        'fecha' => date('Y-m-d'),
        'tipo_tarea' => 'EDC',
        'tipo' => 'solicitud',
        'numero' => Model::where('gestion', date('Y'))->max('numero') + 1,
    ];
});
