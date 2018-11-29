<?php

use Faker\Generator as Faker;
use App\HojaRuta as Model;

$factory->define(Model::class,
    function (Faker $faker) {
    return [
        'gestion' => date('Y'),
        'fecha' => date('Y-m-d'),
        'tipo_tarea' => 'EDC',
        'numero' => Model::where('gestion', date('Y'))->max('numero') + 1,
    ];
});

$factory->state(Model::class, 'externa',
    function (Faker $faker) {
    return [
        'tipo' => 'externa',
    ];
});
