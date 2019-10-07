<?php

use Faker\Generator as Faker;
use App\Reporte as Model;

$factory->define(Model::class,
    function (Faker $faker) {
    return [
        'tipo' => array(),
    ];
});

$factory->state(Model::class, 'externa',
    function (Faker $faker) {
    return [
        'tipo' => 'externa',
    ];
});

$factory->state(Model::class, 'interna',
    function (Faker $faker) {
    return [
        'tipo' => 'interna',
    ];
});

$factory->state(Model::class, 'solicitud',
    function (Faker $faker) {
    return [
        'tipo' => 'solicitud',
    ];
});

$factory->state(Model::class, 'notas',
    function (Faker $faker) {
    return [
        'tipo' => 'notas',
    ];
});

$factory->state(Model::class, 'comunicacion',
    function (Faker $faker) {
    return [
        'tipo' => 'comunicacion',
    ];
});

$factory->state(Model::class, 'informes',
    function (Faker $faker) {
    return [
        'tipo' => 'informes',
    ];
});
