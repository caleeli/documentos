<?php

use Faker\Generator as Faker;
use App\HojaRuta as Model;

$factory->define(Model::class,
    function (Faker $faker) {
    return [
        'tipo_hr' => 'externa',
    ];
});

$factory->state(Model::class, 'ejemplo',
    function (Faker $faker) {
    return [
        'tipo_hr' => 'externa',
        'destinatario' => '1',
        'gestion' => date('Y'),
        'fecha_recepcion' => date('Y-m-d'),
        'tipo_tarea' => 'SCSL-UR',
        'referencia' => $faker->sentence(),
        'procedencia' => $faker->sentence(),
        'nro_de_control' => $faker->numberBetween(100, 999),
        'numero' => $faker->numberBetween(100, 999),
        'tipo_tarea' => 'UR',
        'subtipo_tarea' => '1.1',
        'tipo_procedencia' => 'entidad',
    ];
});

$factory->state(Model::class, 'create',
    function (Faker $faker) {
    return [
        'tipo_hr' => 'externa',
        'numero' => '',
        'gestion' => date('Y'),
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
