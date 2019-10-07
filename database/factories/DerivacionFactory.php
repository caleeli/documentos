<?php

use App\Derivacion;
use App\HojaRuta;
use Faker\Generator as Faker;
use App\Derivacion as Model;

$factory->define(
    Model::class,
    function (Faker $faker) {
        return [
            'fecha' => $faker->dateTimeBetween('-15 days'),
            'comentarios' => $faker->sentence(),
            'destinatarios' => '1',
            'instruccion' => $faker->sentence(),
            'hoja_ruta_id' => function () {
                return factory(HojaRuta::class)->create()->getKey();
            },
            'dias_plazo' => $faker->numberBetween(1, 7),
        ];
    }
);
