<?php

use App\Derivacion;
use App\HojaRuta;
use Faker\Generator as Faker;
use App\Tarea as Model;

$factory->define(
    Model::class,
    function (Faker $faker) {
        $derivacion = factory(Derivacion::class)->states('ejemplo')->make();
        return [
            'hr_id' => function () use ($derivacion) {
                $derivacion->save();
                return $derivacion->hoja_ruta->getKey();
            },
            'derhr_id' => function () use ($derivacion) {
                $derivacion->save();
                return $derivacion->getKey();
            },
            'tar_codigo' => 'SCSL-' . $faker->numberBetween(100, 999),
            'tar_descripcion' => $faker->sentence(),
            'tar_fecha_derivacion' => function () use ($derivacion) {
                $derivacion->save();
                return $derivacion->fecha;
            },
            'tar_creador_id' => 1,
            'tar_estado' => 'Pendiente',
            'tar_avance' => $faker->numberBetween(0, 99),
            'tar_prioridad' => $faker->numberBetween(1, 3),
        ];
    }
);
