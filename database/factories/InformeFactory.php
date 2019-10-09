<?php

use Faker\Generator as Faker;
use App\Informe as Model;

$factory->define(
    Model::class,
    function (Faker $faker) {
        return [
            'gestion' => date('Y'),
        ];
    }
);

$factory->state(
    Model::class,
    'create',
    function (Faker $faker) {
        return [
            'gestion' => date('Y'),
        ];
    }
);
