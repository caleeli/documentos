<?php

use Faker\Generator as Faker;
use App\HojaRuta as Model;

$factory->define(Model::class,
    function (Faker $faker) {
    return [
        'gestion' => date('Y'),
        'fecha_recepcion' => date('Y-m-d'),
        'tipo_tarea' => 'EDC',
        'tipo_hr' => 'externa',
        'referencia' => $faker->sentence(),
        'procedencia' => $faker->sentence(),
        'nro_de_control' => 'SCSL-' . $faker->numberBetween(100, 999),
        'numero' => $faker->numberBetween(100, 999),
    ];
});

$factory->state(Model::class, 'externa',
    function (Faker $faker) {
    return [
        'tipo_hr' => 'externa',
        'numero' => Model::where('gestion', date('Y'))->where('tipo_hr', 'externa')->max('numero') + 1,
    ];
});

$factory->state(Model::class, 'interna',
    function (Faker $faker) {
    return [
        'tipo_hr' => 'interna',
        'numero' => Model::where('gestion', date('Y'))->where('tipo_hr', 'interna')->max('numero') + 1,
    ];
});

$factory->state(Model::class, 'solicitud',
    function (Faker $faker) {
    return [
        'tipo_hr' => 'solicitud',
        'numero' => Model::where('gestion', date('Y'))->where('tipo_hr', 'solicitud')->max('numero') + 1,
    ];
});
