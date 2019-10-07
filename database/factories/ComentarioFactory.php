<?php

use Faker\Generator as Faker;
use App\Comentario as Model;
use Carbon\Carbon;

$factory->define(
    Model::class,
    function (Faker $faker) {
        return [
            'com_fecha' => new Carbon(),
            'com_texto' => $faker->sentence(),
        ];
    }
);
