<?php

use Faker\Generator as Faker;
use App\HojaRuta as Model;

$factory->define(Model::class,
    function (Faker $faker) {
    return [
        'fecha' => date('Y-m-d'),
    ];
});

$factory->state(Model::class, 'externa',
    function (Faker $faker) {
    return [
        'tipo' => 'externa',
    ];
});
